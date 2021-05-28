<?php


namespace App\Controllers;


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
        echo $category_links[1];
        foreach ($category_links as $cat_link)
        {
            echo "TOTAL ".count($articles_to_persist);
            $cat_dom = $this->getDocument($cat_link);
            sleep(3);
            $page_links = $this->extractLinksFromCategory($cat_dom);
            echo $page_links[0] . "<br>";
            foreach ($page_links as $link) {
                $all_articles = $this->iterateOverCategoryPages($link);
                foreach ($all_articles as $item){
                    array_push($articles_to_persist, $item);
                }
            }
        }

        $i = 0;
        foreach ($articles_to_persist as $item)
        {
            echo $i.' '.$item['name'].'<br>';
            $i++;
        }

        echo "Done ".count($articles_to_persist);
    }

    public function test()
    {
        $all_articles = $this->iterateOverCategoryPages('/proizvodi/kucni-ljubimci/hrana-za-pse');
    }

    private function iterateOverCategoryPages(string $page): array
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

            $category_link = $link_node->getAttribute('href');
//            echo $category_link.'<br>';
            if (strpos($category_link, '/kategorija/') === 0) {
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
                    $article['category'] = $category;
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
                $article['prices']['idea'] = $article_row->childNodes->
                item($IDEA_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['maxi'] = $article_row->childNodes->
                item($MAXI_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['univerexport'] = $article_row->childNodes->
                item($UNIVER_EXPORT_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['tempo'] = $article_row->childNodes->
                item($TEMPO_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['dis'] = $article_row->childNodes->
                item($DIS_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['roda'] = $article_row->childNodes->
                item($RODA_OFFSET)->textContent;
            } catch (ErrorException $e) {}
            try {
                $article['prices']['lidl'] = $article_row->childNodes->
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
