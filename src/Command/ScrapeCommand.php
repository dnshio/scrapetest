<?php

namespace Sainsburys\Command;

use Goutte\Client;
use Sainsburys\Service\ProductFetcher;


class ScrapeCommand
{
    /**
     * @var string $savePath
     */
    protected $savePath;

    /**
     * @param string $savePath
     */
    public function __construct($savePath)
    {
        $this->savePath = $savePath;
    }

    public function run()
    {
        $client = new Client();
        $rootUrl = "http://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?listView=true&orderBy=FAVOURITES_FIRST&parent_category_rn=12518&top_category=12518&langId=44&beginIndex=0&pageSize=20&catalogId=10137&searchTerm=&categoryId=185749&listId=&storeId=10151&promotionId=#langId=44&storeId=10151&catalogId=10137&categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true";
        $productFetcher = new ProductFetcher($client, $rootUrl);
        $products = $productFetcher->getProducts();
        $total = 0;
        foreach ($products as $product) {
            $total += $product['unit_price'];
        }
        $jsonArray = [
            'results' => $products,
            'total'   => $total
        ];

        file_put_contents($this->savePath, json_encode($jsonArray, JSON_PRETTY_PRINT));

        print "\nScrape sucessfull!\n";
        print "\nResults saved in " . realpath($this->savePath) . "\n";
    }
}