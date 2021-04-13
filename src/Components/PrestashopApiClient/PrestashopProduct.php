<?php


namespace Components\PrestashopApiClient;

class PrestashopProduct
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var array
     */
    private $descriptions;
    /**
     * @var array
     */
    private $shortDescriptions;
    /**
     * @var array
     */
    private $metaDescriptions;
    /**
     * @var array
     */
    private $metaTitles;
    /**
     * @var array
     */
    private $names;
    /**
     * @var array
     */
    private $linkRewrites;

    /**
     * @return array
     */
    public function getDescriptions(): array
    {
        return $this->descriptions;
    }

    /**
     * @return array
     */
    public function getShortDescriptions(): array
    {
        return $this->shortDescriptions;
    }

    /**
     * @return array
     */
    public function getMetaDescriptions(): array
    {
        return $this->metaDescriptions;
    }

    /**
     * @return array
     */
    public function getMetaTitles(): array
    {
        return $this->metaTitles;
    }

    /**
     * @return array
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * @return array
     */
    public function getLinkRewrites(): array
    {
        return $this->linkRewrites;
    }

    public function __construct(string $apiKey, string $domain, int $id)
    {
        $this->init($apiKey, $domain, $id);
    }


    private function init(string $apiKey, string $domain, int $id)
    {
        $result = file_get_contents("https://{$apiKey}@{$domain}/api/products/{$id}?output_format=JSON");
        $result = json_decode_utf8($result);
        $this->id = $result->product->id;
        $this->descriptions = $result->product->description;
        $this->metaDescriptions = $result->product->meta_description;
        $this->metaTitles = $result->product->meta_title;
        $this->names = $result->product->name;
        $this->shortDescriptions = $result->product->description_short;
        $this->linkRewrites = $result->product->link_rewrite;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
