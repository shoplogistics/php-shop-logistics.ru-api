<?php


namespace Gxs\ShopLogisticsRu\Tests;


use Gxs\ShopLogisticsRu\Api;
use Gxs\ShopLogisticsRu\Pickup;

class PickupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Pickup
     */
    private $pickup;

    public function testAdd()
    {
        //TODO: write test
    }

    public function testAddPlace()
    {
        //TODO: write test
    }

    public function testUpdatePlace()
    {
        //TODO: write test
    }

    protected function setUp()
    {
        $this->pickup = Api::factory(Api::API_KEY_TEST, Api::ENV_TEST)->get('pickup');
    }

    protected function tearDown()
    {
        $this->pickup = null;
    }
}
