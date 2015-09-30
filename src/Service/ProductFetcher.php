<?php

namespace Sainsburys\Service;
use Goutte\Client;
use Sainsburys\Utility\Formatter;

class ProductFetcher
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string - URL of the product index root
     */
    private $rootUrl;

    public function __construct(Client $client, $rootUrl)
    {
        $this->client = $client;
        $this->rootUrl = $rootUrl;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        $products = [];
        $urls = $this->getProductUrls();
        foreach ($urls as $productPageUrl) {
            $products[] = $this->getProductInfoFromUrl($productPageUrl);
        }
        return $products;
    }

    /**
     * @param $url
     * @return array
     */
    private function getProductInfoFromUrl($url)
    {
        $product = [];
        $crawler = $this->client->request('GET', $url);
        $product['title'] = $crawler->filter('div.productTitleDescriptionContainer > h1')->text();
        $descriptionNode = $crawler->filter('div.productText > p');
        if ($descriptionNode->count() > 0) {
            $product['description'] = $descriptionNode->first()->text();
        }
        $price = $crawler->filter('p.pricePerUnit')->text();
        $price = str_replace('£','', $price);
        $price = str_replace('/unit', '', $price);
        $price = floatval($price);
        $product['unit_price'] = $price;
        $bytes = strlen($crawler->html());
        $product['size'] = Formatter::formatBytes($bytes);
        return $product;
    }

    /**
     * @return array
     */
    public function getProductUrls()
    {
        $urls = [];
        $crawler = $this->client->request('GET', $this->rootUrl);
        $urls = $crawler->filter('div.productInfo > h3 > a')->each(function ($node) {
            return (string) $node->attr('href');
        });
        return $urls;
    }
}