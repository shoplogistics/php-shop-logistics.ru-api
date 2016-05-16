<?php


namespace ShopLogisticsRu;


use Heartsentwined\ArgValidator\ArgValidator;
use ShopLogisticsRu\Exception\NotImplementedException;

/**
 * Class Delivery
 * @package ShopLogisticsRu
 */
class Delivery extends ApiClass
{
    const ADD_ERROR_NO = 0;
    const ADD_ERROR_INVALID_DATA_FORMAT = 4;
    const ADD_ERROR_UPDATE = 5;

    const GET_STATUS_ERROR_ORDER_NOT_FOUND = 3;

    const CALC_PRICE_ERROR_INVALID_ARGUMENTS = 45;
    const CALC_PRICE_ERROR_REQUIRED_PICKUP_PLACE = 46;

    /**
     * Required delivery data fields for add
     *
     * @var array
     */
    private $requiredDeliveryFieldsForAdd = [
        'delivery_date' => ['string', 'notEmpty'],
        'date_transfer_to_store' => ['string', 'notEmpty'],
        'from_city' => ['int', 'string', 'notEmpty'],
        'to_city' => ['int', 'string', 'notEmpty'],
        'time_from' => ['string', 'notEmpty'],
        'time_to' => ['string', 'notEmpty'],
        'order_id' => ['string', 'int', 'notEmpty'],
        'address' => ['string', 'notEmpty'],
        'contact_person' => ['string', 'notEmpty'],
        'phone' => ['string', 'notEmpty'],
        'price' => 'float',
        'ocen_price' => 'float',
        'site_name' => 'string',
        'delivery_speed' => ['string', 'notEmpty'],
        'products' => ['array', 'notEmpty']
    ];

    /**
     * Required products data fields for add
     *
     * @var array
     */
    private $requiredProductsFieldsForAdd = [
        'articul' => 'string',
        'name' => ['string', 'notEmpty'],
        'quantity' => 'float',
        'item_price' => 'float'
    ];

    private $requiredFieldsForTariffs = [
        'from_city' => 'int',
        'to_city' => 'int',
        'weight' => ['float', 'null'],
        'order_length' => ['float', 'null'],
        'order_width' => ['float', 'null'],
        'order_height' => ['float', 'null'],
        'num' => 'int',
        'order_price' => 'float',
        'ocen_price' => 'float',
    ];

    /**
     * Delivery constructor.
     *
     * @inheritdoc
     */
    public function __construct($apiKey, $environment = Api::ENV_PROD)
    {
        parent::__construct($apiKey, $environment);
    }

    /**
     * Add new delivery
     *
     * @param array $deliveryData Delivery data
     *
     * @return array|bool Return delivery data or false in case of an error
     * @throws \InvalidArgumentException
     */
    public function add(array $deliveryData)
    {
        ArgValidator::arrayAssert($deliveryData, $this->requiredDeliveryFieldsForAdd);
        ArgValidator::arrayAssert($deliveryData['products'], $this->requiredProductsFieldsForAdd);
        
        if (!$this->callMethod('add_delivery', ['deliveries' => ['delivery' => $deliveryData]])) {
            return false;
        }

        $answerDeliveryData = $this->answer->getData()['deliveries']['delivery'];
        
        if (isset($answerDeliveryData['error_code']) 
            && $answerDeliveryData['error_code'] !== self::ADD_ERROR_NO) {
            $this->errorCode = (int)$answerDeliveryData['error_code'];
            return false;
        }
        
        return $answerDeliveryData;
    }

    /**
     * Get deliveries by filter
     *
     * @param array $filter Filter for deliveries
     *
     * @return bool|array Return deliveries list or false in case of an error
     * @throws \InvalidArgumentException
     */
    public function getDeliveries(array $filter)
    {
        ArgValidator::arrayAssert($filter, [
            'delivery_date' => 'string',
            'order_id' => ['string', 'int'],
            'code' => 'string',
            'start_date_added' => 'string',
            'end_date_added' => 'string'
        ]);

        if (!$this->callMethod('get_deliveries', $filter)) {
            return false;
        }

        $answerDeliveries = $this->answer->getData()['deliveries'];

        if (isset($answerDeliveries['delivery']) && is_array($answerDeliveries['delivery'])) {
            return $answerDeliveries['delivery'];
        }

        return [];
    }

    /**
     * Get delivery status by code
     *
     * @param string $deliveryCode Delivery code
     *
     * @return bool|array Return delivery status data or false in case of an error
     */
    public function getStatus($deliveryCode)
    {
        ArgValidator::assert($deliveryCode, ['notEmpty']);

        if (!$this->callMethod('get_order_status', ['code' => $deliveryCode])) {
            return false;
        }

        return $this->answer->getData()['deliveries']['delivery'];
    }

    /**
     * Get list of delivery statuses data
     *
     * @param array $deliveryCodes List of delivery codes
     *
     * @return bool|array Return list of delivery statuses data or false in case of an error
     */
    public function getStatuses(array $deliveryCodes)
    {
        ArgValidator::assert($deliveryCodes, ['arrayOf', 'string']);

        if (!$this->callMethod('get_order_status_array', ['deliveries' => ['code' => $deliveryCodes]])) {
            return false;
        }

        return $this->answer->getData()['deliveries']['delivery'];
    }

    /**
     * Update site name
     *
     * @param int $code Code
     * @param string $siteName Site name
     *
     * @throws NotImplementedException
     */
    public function updateSiteName($code, $siteName)
    {
        throw new NotImplementedException(__CLASS__, __METHOD__);
    }

    /**
     * Calculate estimated delivery time and price
     *
     * @param array $parameters Parameters for calculate
     *
     * @return array|bool Return array with time and price or false in case of an error
     */
    public function calculateDeliveryTimeAndPrice(array $parameters)
    {
        ArgValidator::arrayAssert($parameters, array_merge($this->requiredFieldsForTariffs, [
            'tarifs_type' => ['int', 'min' => 1, 'max' => 2],
            'delivery_partner' => ['string', 'null'],
            'pickup_place' => 'int'
        ]));
        
        if (!$this->callMethod('get_delivery_price', $parameters)) {
            return false;
        }

        $answerPriceData = $this->answer->getData();

        if ($answerPriceData['error_code'] !== self::ADD_ERROR_NO) {
            return false;
        }

        return $answerPriceData;
    }

    /**
     * Calculate estimated delivery time
     *
     * @param array $parameters Parameters for calculate
     *
     * @return bool|string Return estimated delivery time or false in case of an error
     */
    public function calculateEstimatedDeliveryTime(array $parameters)
    {
        $result = $this->calculateDeliveryTimeAndPrice($parameters);

        if (!$result) {
            return false;
        }

        return $result['srok_dostavki'];
    }

    /**
     * Calculate delivery price
     *
     * @param array $parameters Parameters for calculate
     *
     * @return bool|float Return delivery price or false in case of an error
     */
    public function calculateDeliveryPrice(array $parameters)
    {
        $result = $this->calculateDeliveryTimeAndPrice($parameters);

        if (!$result) {
            return false;
        }

        return $result['price'];
    }

    /**
     * Get delivery variants by parameters
     *
     * @param array $parameters Parameters
     *
     * @return bool|array Return delivery variants or false in case of an error
     */
    public function getVariants(array $parameters)
    {
        ArgValidator::arrayAssert($parameters, $this->requiredFieldsForTariffs);

        if (!$this->callMethod('get_deliveries_tarifs', $parameters)) {
            return false;
        }

        return $this->answer->getData()['tarifs']['tarif'];
    }

    /**
     * Get delivery tariffs
     *
     * @param array $parameters Parameters
     *
     * @return bool|array Return all delivery tariffs or false in case of an error
     */
    public function getTariffs(array $parameters)
    {
        ArgValidator::arrayAssert($parameters, [
            'from_city_code' => 'int',
            'weight' => ['float', 'null'],
            'order_length' => ['float', 'null'],
            'order_width' => ['float', 'null'],
            'order_height' => ['float', 'null'],
            'delivery_type' => ['string', 'notEmpty'],
            'num' => 'int',
            'max_price' => ['int', 'min' => 0]
        ]);

        if (!$this->callMethod('get_all_tarifs', $parameters)) {
            return false;
        }

        return $this->answer->getData()['tarifs']['tarif'];
    }


}