<?php


namespace Gxs\ShopLogisticsRu;

use Gxs\ShopLogisticsRu\Exception\NotImplementedException;

/**
 * Class Products
 * @package ShopLogisticsRu
 */
class Products extends ApiClass
{
    /**
     * Products constructor.
     * 
     * @inheritdoc
     */
    public function __construct($apiKey, $environment = Api::ENV_PROD)
    {
        parent::__construct($apiKey, $environment);
    }

    /**
     * Add new single product
     *
     * @param array $productData Product data
     *
     * @throws NotImplementedException
     */
    public function add(array $productData)
    {
        throw new NotImplementedException(__CLASS__, __METHOD__);
    }

    /**
     * Get products
     *
     * @throws NotImplementedException
     */
    public function getProducts()
    {
        throw new NotImplementedException(__CLASS__, __METHOD__);
    }

    /**
     * Add new product act
     *
     * @param array $productActData
     *
     * @throws NotImplementedException
     */
    public function addAct(array $productActData)
    {
        throw new NotImplementedException(__CLASS__, __METHOD__);
    }
}