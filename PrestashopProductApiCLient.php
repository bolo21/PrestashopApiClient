<?php


namespace Components\PrestashopApiClient;

class PrestashopProductApiCLient
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
            throw new \Exception("Cannot access the api : {$access}");
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
            array_push($this->productIds, $objId->id);
        }
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getProducts(int $limit)
    {
        $prestashopProducts = [];
        foreach ($this->productIds as $key => $productId) {
            if ($key == $limit) {
                break;
            }
            array_push($prestashopProducts, new PrestashopProduct($this->apiKey, $productId));
        }
        return $prestashopProducts;
    }
}
