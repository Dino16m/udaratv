<?php 

namespace App\Services;



class scraperService{

    private const Urls = [];

    private static function scrape($uri)
    {
        $html = file_get_contents($uri);

        $dom = new DOMDocument();

        libxml_use_internal_errors(TRUE);

        if($empty($html)){
            return;
        }
        $dom->loadHtml($html);

        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $h2elements = $xpath->query("//li[@class='nav-item']");

        foreach ($h2elements as $element) {
            print($element->nodeValue.'<br>');
        };

    }
}