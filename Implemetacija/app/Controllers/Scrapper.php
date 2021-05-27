<?php


namespace App\Controllers;


use DOMNode;
use Masterminds\HTML5;
use mysql_xdevapi\Result;

class Scrapper extends BaseController
{
    public function index()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://cenoteka.rs/proizvodi/namirnice/brasno");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);

        curl_close($ch);

        $document = new HTML5();
        $dom = $document->loadHTML($result);
        $table_candidates = $dom->getElementsByTagName("section");
        $table = $table_candidates->item(1);
        $nav = $dom->getElementById("category-menu");
        echo $nav->textContent;
        $this->extractLinksFromNav($nav);
        $this->exportTable($table);

        echo "Done"."\n"."Done";
    }



    private function extractLinksFromNav(DOMNode $nav)
    {
//        $MACRO_CATEGORIES = ['namirnice', 'zdrava-hrana', 'mlecni-proizvodi', 'voce-i-povrce',
//                                'meso-i-riba', 'smrznuto', 'pica', 'slatkisi-i-grickalice',
//                                'licna-higijena'];
        $categories_links = [];

        $nav->

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
                $article['category'] = $category;
                array_push($articles, $article);
            }
        }

    }

    private function extractArticle(DOMNode $article_row): array
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


        $article['img_link'] = $article_row->childNodes->
                                    item($IMAGE_DIV_OFFSET)->childNodes->
                                    item(1)->attributes->getNamedItem("href")->textContent;

        $article['name'] = $article_row->childNodes->
                                    item($NAME_DIV_OFFSET)->textContent;

        $article['quantity'] = $article_row->childNodes->
                                    item($QUANTITY_DIV_OFFSET)->textContent;

        $article['prices'] = [];

        $article['prices']['idea'] = $article_row->childNodes->
                                        item($IDEA_OFFSET)->textContent;
        $article['prices']['maxi'] = $article_row->childNodes->
                                        item($MAXI_OFFSET)->textContent;
        $article['prices']['univerexport'] = $article_row->childNodes->
                                        item($UNIVER_EXPORT_OFFSET)->textContent;
        $article['prices']['tempo'] = $article_row->childNodes->
                                        item($TEMPO_OFFSET)->textContent;
        $article['prices']['dis'] = $article_row->childNodes->
                                        item($DIS_OFFSET)->textContent;
        $article['prices']['roda'] = $article_row->childNodes->
                                        item($RODA_OFFSET)->textContent;
        $article['prices']['lidl'] = $article_row->childNodes->
                                        item($LIDL_OFFSET)->textContent;
        return $article;
    }

    public function getElementByAttribute(\DOMDocument $dom, string $tag, string $attribute, string $value)
    {
        $result = [];
        foreach ($dom->getElementsByTagName($tag) as $node)
        {
            if ($node->getAttribute($attribute) == $value) {
                array_push($result, $node);
            }
        }

        return $result;
    }

    public function run()
    {

        $scrapper = new Scrapper();
        $scrapper->index();
    }
}
