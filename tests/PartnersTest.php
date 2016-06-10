<?php


namespace Gxs\ShopLogisticsRu\Tests;


use Gxs\ShopLogisticsRu\Api;
use Gxs\ShopLogisticsRu\Partners;

class PartnersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Partners
     */
    private $partners;

    public function testGetPartners()
    {
        $getPartnersResult = $this->partners->getPartners(405065);
        $this->assertNotFalse($getPartnersResult);

        if (count($getPartnersResult) > 0) {
            $this->assertArrayHasKey('to_city_code', $getPartnersResult[0]);
            $this->assertArrayHasKey('delivery_partner', $getPartnersResult[0]);
        }
    }

    protected function setUp()
    {
        $this->partners = Api::factory(Api::API_KEY_TEST, Api::ENV_TEST)->get('partners');
    }

    protected function tearDown()
    {
        $this->partners = null;
    }
}
