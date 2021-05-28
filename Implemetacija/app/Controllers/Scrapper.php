<?php


namespace App\Controllers;


use App\Models\CategoryModel;
use App\Models\ItemCategoryModel;
use App\Models\ItemModel;
use App\Models\ItemPriceModel;
use App\Models\ShopChainModel;
use App\Models\ShoppingListModel;
use DOMNode;
use ErrorException;
use Masterminds\HTML5;
use mysql_xdevapi\Result;
use PhpParser\Error;

class Scrapper extends BaseController
{
    public function index()
    {
        $dom = $this->getDocument('');
        $category_links = $this->extractLinksFromNav($dom);

        $articles_to_persist = [];
        foreach ($category_links as $cat_link)
        {
            echo $cat_link['href'].' '.$cat_link['name'];
            echo "TOTAL ".count($articles_to_persist);
            $cat_dom = $this->getDocument($cat_link['href']);
            sleep(3);
            $page_links = $this->extractLinksFromCategory($cat_dom);
            foreach ($page_links as $link) {
                $all_articles = $this->iterateOverCategoryPages($link, $cat_link['name']);
                foreach ($all_articles as $item){
                    array_push($articles_to_persist, $item);
                }
            }
        }

        $this->persistArticles($articles_to_persist);
        echo "Done ".count($articles_to_persist);
    }

    private function test()
    {
        $dom = $this->getDocument('');
        $category_links = $this->extractLinksFromNav($dom);

        $articles_to_persist = [];
        $cat_link = $category_links[1];
        echo $cat_link['href'].' '.$cat_link['name'];
        echo "TOTAL ".count($articles_to_persist);
        $cat_dom = $this->getDocument($cat_link['href']);
        sleep(3);
        $page_links = $this->extractLinksFromCategory($cat_dom);
        $link = $page_links[0];
        $all_articles = $this->iterateOverCategoryPages($link, $cat_link['name']);
        foreach ($all_articles as $item){
            array_push($articles_to_persist, $item);
        }

        $i = 0;
        foreach ($articles_to_persist as $item)
        {
            echo $i.' '.$item['name'].'<br>';
            $i++;
        }

        $this->persistArticles($articles_to_persist);

        echo "Done ".count($articles_to_persist);
    }

    private function persistArticles(array $articles_to_persist)
    {
        $failed = 0;
        foreach ($articles_to_persist as $item)
        {
            try {
                $idItem = $this->persistItem($item);
                $this->persistShoppPrices($idItem, $item);
                $this->persistItemCategory($idItem, $item['category']);
            } catch (ErrorException $e) {
                echo "[ERROR] ".$e->getMessage().'<br>';
                $failed++;
            }
        }
    }

    private function persistItem(array $item)
    {
        $itemModel = new ItemModel();
        $itemExists = $itemModel->where('name', $item['name'])
                                    ->where('isCenoteka', 1)->first();

        if ($itemExists != null)
        {
            return $itemExists['idItem'];
        }

        $quantity_metrics = explode(' ', $item['quantity']);
        $data = [
            'name' => $item['name'],
            'isCenoteka' => 1,
            'quantity' => $quantity_metrics[0],
            'metrics' => $quantity_metrics[1],
            'image' => $item['img_link'],
        ];

        if (!($idItem = $itemModel->insert($data)))
        {
            echo implode('; ', $data);
            throw new ErrorException('Item not persisted '.$item['name'].' '.implode(' ', $itemModel->errors()));
        }
        return $idItem;

    }

    private function persistItemCategory(int $idItem, string $categoryName)
    {
        $categoryName = trim($categoryName);
        $categoryModel = new CategoryModel();
        $category = $categoryModel->where('name', $categoryName)->first();
        if ($category == null) {
            $idCategory = $categoryModel->insert(['name' => $categoryName]);
            if ($idCategory == null) {
                echo "[ERROR]: ".$categoryName.' failed '.implode(" ", $categoryModel->errors()).' <br>';
                return;
            }
            $category = $categoryModel->find($idCategory);
        }

        $itemCategoryModel = new ItemCategoryModel();
        $itemCategory = $itemCategoryModel->where('idItem', $idItem)
                                            ->where('idCategory', $category['idCategory'])->first();
        if ($itemCategory == null) {
            if (!$itemCategoryModel->insert(['idItem' => $idItem, 'idCategory' => $category['idCategory']])) {
                echo '[ERROR] '.implode(' ', $itemCategoryModel->errors());
            }
        }
    }

    private function persistShoppPrices(int $idItem, array $data)
    {
        foreach ($data['prices'] as $shopName => $price) {
            if ($price == '-')
                continue;

            str_replace(',', '.', $price);
            $shopChainModel = new ShopChainModel();
            $shop = $shopChainModel->where('name', $shopName)->first();
            $idShop = null;
            if ($shop == null) {
                $idShop = $shopChainModel->insert(['name' => $shopName]);
            }
            else {
                $idShop = $shop['idShopChain'];
            }

            $itemPriceModel = new ItemPriceModel();
            $itemPrice = $itemPriceModel->where('idItem', $idItem)
                                        ->where('idShopChain', $idShop)->first();

            if ($itemPrice == null) {
                $itemPriceModel->insert(['idItem' => $idItem, 'price' => $price, 'idShopChain' => $idShop] );
            }
            else {
                $itemPrice['price'] = $price;
                $itemPriceModel->update($itemPrice['idItemPrice'], $itemPrice);
            }
        }
    }

    private function iterateOverCategoryPages(string $page, string $category): array
    {
        $all_articles = [];
        $pageNum = 1;
        do {
            $dom = $this->getDocument($page.'?page='.$pageNum);

            $section_tag = $this->getElementsByAttribute($dom, 'section', 'class', 'list-articles-content');
            echo "sect ".count($section_tag).'<br>';
            $new = 0;
            foreach ($section_tag as $section)
            {
                $articles = $this->exportTable($section);
                foreach ($articles as $item)
                {
                    echo $item['name'].'<br>';
                    $new++;
                    $item['category'] = $category;
                    array_push($all_articles, $item);
                }
            }
            echo "count ".$new."<br>";
            if ($new == 0)
            {
                break;
            }

            sleep(3);
            $pageNum++;
        } while (true);

        return $all_articles;
    }

    private function extractLinksFromNav(\DOMDocument $dom)
    {
        $link_nodes = $this->getElementsByAttribute($dom, 'a', 'class', 'nav-link dropdown-toggle');

        $category_links = [];

        foreach ($link_nodes as $link_node)
        {
            $category_link = [];
            $category_link['href'] = $link_node->getAttribute('href');
            $category_link['name'] = $link_node->textContent;
            if (strpos($category_link['href'], '/kategorija/') === 0) {
                array_push($category_links, $category_link);
            }
        }

        return $category_links;
    }

    private function extractLinksFromCategory(\DOMDocument $dom)
    {
        $item_nodes = $this->getElementsByAttribute($dom, 'div', 'class', 'cat-list-item');
        $item_links = [];

        echo count($item_nodes);
        foreach ($item_nodes as $node)
        {
            if ($node->childNodes->item(1)->nodeName == 'a')
            {
                $link = $node->childNodes->item(1)->getAttribute('href');
                array_push($item_links, $link);
            }
        }

        return $item_links;
    }

    private function exportTable(DOMNode $table)
    {
        $HEADER_OFFSET = 1;
        $ARTICLE_OFFSET = 2;
        $count = $table->childNodes->count();
        $category = $table->childNodes->item($HEADER_OFFSET)->textContent;


        $articles = [];

        for ($i = $ARTICLE_OFFSET; $i < $count; $i++)
        {
            $article_row = $table->childNodes->item($i);
            if ($article_row->childNodes->count() != 0)
            {
                $article = $this->extractArticle($article_row);
                if ($article != null)
                {
//                    $article['category'] = $category;
                    array_push($articles, $article);
                }
            }
        }

        return $articles;
    }

    private function extractArticle(DOMNode $article_row): ?array
    {
        $IMAGE_DIV_OFFSET = 1;
        $NAME_DIV_OFFSET = 3;
        $QUANTITY_DIV_OFFSET = 5;

        $IDEA_OFFSET = 9;
        $MAXI_OFFSET = 11;
        $UNIVER_EXPORT_OFFSET = 13;
        $TEMPO_OFFSET = 15;
        $DIS_OFFSET = 17;
        $RODA_OFFSET = 19;
        $LIDL_OFFSET = 21;

        $article = [];

        try {

            $article['img_link'] = $article_row->childNodes->
            item($IMAGE_DIV_OFFSET)->childNodes->
            item(1)->getAttribute('href');//attributes->getNamedItem("href")->textContent;

            $article['name'] = $article_row->childNodes->
            item($NAME_DIV_OFFSET)->textContent;

            echo $article['name'] . '<br>';
            $article['quantity'] = $article_row->childNodes->
            item($QUANTITY_DIV_OFFSET)->textContent;

            $article['prices'] = [];

            try {
                $article['prices']['Idea'] = $article_row->childNodes->
                item($IDEA_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['Maxi'] = $article_row->childNodes->
                item($MAXI_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['Univerexport'] = $article_row->childNodes->
                item($UNIVER_EXPORT_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['Tempo'] = $article_row->childNodes->
                item($TEMPO_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['Dis'] = $article_row->childNodes->
                item($DIS_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['Roda'] = $article_row->childNodes->
                item($RODA_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['Lidl'] = $article_row->childNodes->
                item($LIDL_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            return $article;
        } catch (ErrorException $e) {
            echo "Failed ".$e." <br>";
        }
        return null;
    }

    public function getElementsByAttribute(\DOMDocument $dom, string $tag, string $attribute, string $value): array
    {
        $result = [];
        foreach ($dom->getElementsByTagName($tag) as $node)
        {
            $attr = $node->getAttribute($attribute);
            if (strpos($attr, $value) !== false) {
                array_push($result, $node);
            }
        }

        return $result;
    }

    private function getDocument(string $url_no_base)
    {
        $ch = curl_init();

        echo "<br>CURL: "."https://cenoteka.rs".$url_no_base."<br>";
        curl_setopt($ch, CURLOPT_URL, "https://cenoteka.rs".$url_no_base);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);

        curl_close($ch);

        $document = new HTML5();
        $dom = $document->loadHTML($result);

        return $dom;
    }

    public function run()
    {

        $scrapper = new Scrapper();
        $scrapper->index();
    }
}
