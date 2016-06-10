<?php


namespace Gxs\ShopLogisticsRu\Tests;


use Gxs\ShopLogisticsRu\Api;
use Gxs\ShopLogisticsRu\Delivery;

class DeliveryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Delivery
     */
    private $delivery;

    public function testGetDeliveries()
    {
        $getDeliveriesResult = $this->delivery->getDeliveries(['status' => 'Новый']);
        $this->assertNotFalse($getDeliveriesResult);

        if (count($getDeliveriesResult) > 0) {
            $this->assertArrayHasKey('code', $getDeliveriesResult[0]);
            $this->assertArrayHasKey('delivery_date', $getDeliveriesResult[0]);
            $this->assertArrayHasKey('from_city', $getDeliveriesResult[0]);
            $this->assertArrayHasKey('to_city', $getDeliveriesResult[0]);
            //TODO: write assertions
        }
    }

    public function testGetStatus()
    {
        $getStatusResult = $this->delivery->getStatus('135833975800056758');
        $this->assertNotFalse($getStatusResult);

        if (count($getStatusResult) > 0) {
            $this->assertArrayHasKey('code', $getStatusResult[0]);
            $this->assertArrayHasKey('order_id', $getStatusResult[0]);
            $this->assertArrayHasKey('status', $getStatusResult[0]);
            $this->assertArrayHasKey('payment_status', $getStatusResult[0]);
            $this->assertArrayHasKey('vozvrat_status', $getStatusResult[0]);
            $this->assertArrayHasKey('products', $getStatusResult[0]);
        }
    }

    public function testGetStatuses()
    {
        $getStatusesResult = $this->delivery->getStatuses(['135833975800056758', '135833991800056752']);
        $this->assertNotFalse($getStatusesResult);

        if (count($getStatusesResult) > 0) {
            $this->assertArrayHasKey('code', $getStatusesResult[0]);
            $this->assertArrayHasKey('order_id', $getStatusesResult[0]);
            $this->assertArrayHasKey('status', $getStatusesResult[0]);
            $this->assertArrayHasKey('payment_status', $getStatusesResult[0]);
            $this->assertArrayHasKey('vozvrat_status', $getStatusesResult[0]);
            $this->assertArrayHasKey('products', $getStatusesResult[0]);
        }
    }

    public function testCalculateDeliveryTimeAndPrice()
    {
        $parameters = [
            'from_city' => 405065,
            'to_city' => 958281,
            'order_price' => 12.12,
            'ocen_price' => 13.13,
            'tarifs_type' => 2,
            'weight' => 1,
            'num' => 1,
            'delivery_partner' => '',
            'pickup_place' => 470558
        ];
        $getCalculateDeliveryTimeAndPrice = $this->delivery->calculateDeliveryTimeAndPrice($parameters);
        //FIXME: Result array keys
        $this->assertFalse($getCalculateDeliveryTimeAndPrice);
    }

    public function testGetVariants()
    {
        $parameters = [
            'from_city' => 405065,
            'to_city' => 405065,
            'num' => 1,
            'delivery_type' => 'all',
            'weight' => 1,
            'max_price' => 99999,
            'order_price' => 12.12,
            'ocen_price' => 13.13
        ];
        $getVariantsResult = $this->delivery->getVariants($parameters);
        $this->assertNotFalse($getVariantsResult);

        if (count($getVariantsResult) > 0) {
            $this->assertArrayHasKey('price', $getVariantsResult[0]);
            $this->assertArrayHasKey('tarifs_type', $getVariantsResult[0]);
            $this->assertArrayHasKey('srok_dostavki', $getVariantsResult[0]);
            $this->assertArrayHasKey('pickup_place', $getVariantsResult[0]);
            $this->assertArrayHasKey('address', $getVariantsResult[0]);
            $this->assertArrayHasKey('pickup_place', $getVariantsResult[0]);
            $this->assertArrayHasKey('proezd_info', $getVariantsResult[0]);
            $this->assertArrayHasKey('phone', $getVariantsResult[0]);
            $this->assertArrayHasKey('worktime', $getVariantsResult[0]);
            $this->assertArrayHasKey('comission_percent', $getVariantsResult[0]);
            $this->assertArrayHasKey('is_terminal', $getVariantsResult[0]);
            $this->assertArrayHasKey('to_city_code', $getVariantsResult[0]);
            $this->assertArrayHasKey('pickup_place_code', $getVariantsResult[0]);
            $this->assertArrayHasKey('delivery_partner', $getVariantsResult[0]);
            $this->assertArrayHasKey('is_basic', $getVariantsResult[0]);
        }
    }

    public function testGetTariffs()
    {
        $parameters = [
            'from_city_code' => 405065,
            'num' => 1,
            'delivery_type' => 'all',
            'weight' => 1,
            'max_price' => 99999,
        ];
        $getTariffsResult = $this->delivery->getTariffs($parameters);
        $this->assertNotFalse($getTariffsResult);

        if (count($getTariffsResult) > 0) {
            $this->assertArrayHasKey('to_city_code', $getTariffsResult[0]);
            $this->assertArrayHasKey('pickup_place_code', $getTariffsResult[0]);
            $this->assertArrayHasKey('price', $getTariffsResult[0]);
            $this->assertArrayHasKey('tarifs_type', $getTariffsResult[0]);
            $this->assertArrayHasKey('srok_dostavki', $getTariffsResult[0]);
            $this->assertArrayHasKey('max_price', $getTariffsResult[0]);
            $this->assertArrayHasKey('max_weight', $getTariffsResult[0]);
            $this->assertArrayHasKey('comission_percent', $getTariffsResult[0]);
            $this->assertArrayHasKey('tariffs_comment', $getTariffsResult[0]);
            $this->assertArrayHasKey('delivery_partner', $getTariffsResult[0]);
            $this->assertArrayHasKey('is_basic', $getTariffsResult[0]);
        }
    }

    protected function setUp()
    {
        $this->delivery = Api::factory(Api::API_KEY_TEST, Api::ENV_TEST)->get('delivery');
    }

    protected function tearDown()
    {
        $this->delivery = null;
    }
}
