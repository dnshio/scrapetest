<?php
namespace Sainsburys\Test\Service;
use Goutte\Client;
use Sainsburys\Service\ProductFetcher;

class ProductFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductFetcher
     */
    protected $productFetcher;

    protected function setUp()
    {
        $client = new Client();
        $rootUrl = "http://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?listView=true&orderBy=FAVOURITES_FIRST&parent_category_rn=12518&top_category=12518&langId=44&beginIndex=0&pageSize=20&catalogId=10137&searchTerm=&categoryId=185749&listId=&storeId=10151&promotionId=#langId=44&storeId=10151&catalogId=10137&categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true";
        $this->productFetcher = new ProductFetcher($client, $rootUrl);
    }

    public function testGetProductUrlsReturnsArray()
    {
        $urls = $this->productFetcher->getProductUrls();
        $this->assertNotEmpty($urls);
    }

    public function testGetProductsReturnsAnArray()
    {
        $products = $this->productFetcher->getProducts();
        $this->assertTrue(is_array($products));
        return $products;
    }

    /**
     * @depends testGetProductsReturnsAnArray
     */
    public function testProductsArrayContainsProducts(array $products)
    {
        $this->assertGreaterThan(0, count($products));
    }

    /**
     * @depends testGetProductsReturnsAnArray
     */
    public function testEachProductHasRequiredProperties(array $products)
    {
        foreach ($products as $product) {
            $this->assertArrayHasKey('title', $product);
            $this->assertArrayHasKey('description', $product);
            $this->assertArrayHasKey('unit_price', $product);
            $this->assertArrayHasKey('size', $product);
        }
    }

    /**
     * @depends testGetProductsReturnsAnArray
     */
    public function testUnitPriceIsNumeric(array $products)
    {
        foreach ($products as $product) {
            $this->assertTrue(is_numeric($product['unit_price']));
        }
    }
}