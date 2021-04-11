<?php


namespace Components\PrestashopApiClient;

use Components\PrestashopApiClient\Exception\ProductNotFoundException;
use Exception;

class PrestashopProductApiClient
{
    /**
     * @var array
     */
    private $productIds = [];
    /**
     * @var string
     */
    private $apiKey;

    public function __construct(string $apiKey, string $domain)
    {
        $this->apiKey = $apiKey;
        $access = "https://{$apiKey}@{$domain}/api/products/?output_format=JSON";
        $json = file_get_contents($access);
        if (!isset($json)) {
            throw new Exception("Cannot access the api : {$access}");
        }
        $this->setProductIds($json);
    }
    
    /**
     * @param string $json
     */
    private function setProductIds(string $json)
    {
        $this->productIds = [];
        $objIds = json_decode_utf8($json);
        $objIds = $objIds->products;
        foreach ($objIds as $objId) {
            $this->productIds[$objId->id] = $objId->id;
        }
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getProducts(int $limit)
    {
        $prestashopProducts = [];
        foreach ($this->productIds as $productId) {
            if (count($prestashopProducts) == $limit) {
                break;
            }
            array_push($prestashopProducts, new PrestashopProduct($this->apiKey, $productId));
        }
        return $prestashopProducts;
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getProductsByIds(array $ids)
    {
        $prestashopProducts = [];
        foreach ($ids as $productId) {
            if (!isset($this->productIds[$productId])) {
                new ProductNotFoundException("Product having id {$productId} does not exist");
            }
            array_push($prestashopProducts, new PrestashopProduct($this->apiKey, $productId));
        }
        return $prestashopProducts;
    }
}

