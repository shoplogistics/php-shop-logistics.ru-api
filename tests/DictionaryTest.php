<?php


namespace Gxs\ShopLogisticsRu\Tests;


use Gxs\ShopLogisticsRu\Api;
use Gxs\ShopLogisticsRu\Dictionary;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Dictionary
     */
    private $dictionary;

    public function testGetCities()
    {
        $getCitiesResult = $this->dictionary->getCities();
        $this->assertNotFalse($getCitiesResult);

        if (count($getCitiesResult) > 0) {
            $this->assertArrayHasKey('name', $getCitiesResult[0]);
            $this->assertArrayHasKey('code_id', $getCitiesResult[0]);
            $this->assertArrayHasKey('is_courier', $getCitiesResult[0]);
            $this->assertArrayHasKey('is_filial', $getCitiesResult[0]);
            $this->assertArrayHasKey('oblast_code', $getCitiesResult[0]);
        }
    }

    public function testGetMetro()
    {
        $getMetroResult = $this->dictionary->getMetro();
        $this->assertNotFalse($getMetroResult);

        if (count($getMetroResult) > 0) {
            $this->assertArrayHasKey('city_name', $getMetroResult[0]);
            $this->assertArrayHasKey('city_code_id', $getMetroResult[0]);
            $this->assertArrayHasKey('name', $getMetroResult[0]);
            $this->assertArrayHasKey('code_id', $getMetroResult[0]);
        }
    }

    public function testGetPickups()
    {
        $getPickupsResult = $this->dictionary->getPickups();
        $this->assertNotFalse($getPickupsResult);

        if (count($getPickupsResult) > 0) {
            $this->assertArrayHasKey('city_name', $getPickupsResult[0]);
            $this->assertArrayHasKey('city_code_id', $getPickupsResult[0]);
            $this->assertArrayHasKey('name', $getPickupsResult[0]);
            $this->assertArrayHasKey('pickup_places_type', $getPickupsResult[0]);
            $this->assertArrayHasKey('address', $getPickupsResult[0]);
            $this->assertArrayHasKey('proezd_info', $getPickupsResult[0]);
            $this->assertArrayHasKey('phone', $getPickupsResult[0]);
            $this->assertArrayHasKey('worktime', $getPickupsResult[0]);
            $this->assertArrayHasKey('srok_dostavki', $getPickupsResult[0]);
            $this->assertArrayHasKey('code_id', $getPickupsResult[0]);
            $this->assertArrayHasKey('latitude', $getPickupsResult[0]);
            $this->assertArrayHasKey('longitude', $getPickupsResult[0]);
            $this->assertArrayHasKey('trying_on_clothes', $getPickupsResult[0]);
            $this->assertArrayHasKey('trying_on_shoes', $getPickupsResult[0]);
            $this->assertArrayHasKey('payment_cards', $getPickupsResult[0]);
            $this->assertArrayHasKey('receiving_orders', $getPickupsResult[0]);
            $this->assertArrayHasKey('partial_redemption', $getPickupsResult[0]);
            $this->assertArrayHasKey('return_to_recipient', $getPickupsResult[0]);
        }
    }

    public function testGetAffiliate()
    {
        $getAffiliateResult = $this->dictionary->getAffiliate();
        $this->assertNotFalse($getAffiliateResult);
        
        if (count($getAffiliateResult) > 0) {
            $this->assertArrayHasKey('city_name', $getAffiliateResult[0]);
            $this->assertArrayHasKey('city_code_id', $getAffiliateResult[0]);
            $this->assertArrayHasKey('name', $getAffiliateResult[0]);
            $this->assertArrayHasKey('type', $getAffiliateResult[0]);
            $this->assertArrayHasKey('code_id', $getAffiliateResult[0]);
        }
    }

    public function testGetStatuses()
    {
        $getStatusesResult = $this->dictionary->getStatuses();
        $this->assertNotFalse($getStatusesResult);
        
        if (count($getStatusesResult) > 0) {
            $this->assertArrayHasKey('name', $getStatusesResult[0]);
        }
    }

    public function testGetPartners()
    {
        $getPartnersResult = $this->dictionary->getPartners();
        $this->assertNotFalse($getPartnersResult);

        if (count($getPartnersResult) > 0) {
            $this->assertArrayHasKey('name', $getPartnersResult[0]);
            $this->assertArrayHasKey('code_id', $getPartnersResult[0]);
            $this->assertArrayHasKey('is_courier_partner', $getPartnersResult[0]);
        }
    }

    public function testGetStates()
    {
        $getStatesResult = $this->dictionary->getStates();
        $this->assertNotFalse($getStatesResult);
        
        if (count($getStatesResult) > 0) {
            $this->assertArrayHasKey('name', $getStatesResult[0]);
            $this->assertArrayHasKey('code', $getStatesResult[0]);
        }
    }

    public function testGetDistricts()
    {
        $getDistrictsResult = $this->dictionary->getDistricts();
        $this->assertNotFalse($getDistrictsResult);
        
        if (count($getDistrictsResult) > 0) {
            $this->assertArrayHasKey('name', $getDistrictsResult[0]);
            $this->assertArrayHasKey('code', $getDistrictsResult[0]);
            $this->assertArrayHasKey('oblast_code', $getDistrictsResult[0]);
        }
    }

    protected function setUp()
    {
        $this->dictionary = Api::factory(Api::API_KEY_TEST, Api::ENV_TEST)->get('dictionary');
    }
    
    protected function tearDown()
    {
        $this->dictionary = null;
    }
}
