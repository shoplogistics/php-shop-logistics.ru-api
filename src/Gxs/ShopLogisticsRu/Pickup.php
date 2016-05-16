<?php


namespace Gxs\ShopLogisticsRu;

use Heartsentwined\ArgValidator\ArgValidator;

/**
 * Class Pickup
 * @package ShopLogisticsRu
 */
class Pickup extends ApiClass
{
    const ADD_ERROR_NO = 0;
    const ADD_ERROR_DATE_CLOSED = 43;
    const ADD_ERROR_PICKUP_EXISTS = 44;

    /**
     * Required data fields for add new pickup place
     * 
     * @var array
     */
    private $requiredFieldsForAddPlace = [
        'address' => ['string', 'notEmpty'],
        'contact_person' => ['string', 'notEmpty'],
        'phone' => 'string',
        'zabor_from_supplier' => ['int', 'min' => 0, 'max' => 1],
        'name_supplier' => 'string',
        'is_regular_days' => ['string', 'notEmpty'],
        'add_documents' => ['int', 'min' => 0, 'max' => 1],
        'time_from' => ['string', 'notEmpty'],
        'time_to' => ['string', 'notEmpty']
    ];

    /**
     * Pickup constructor.
     * 
     * @inheritdoc
     */
    public function __construct($apiKey, $environment = Api::ENV_PROD)
    {
        parent::__construct($apiKey, $environment);
    }

    /**
     * Add new pickup
     *
     * @param string $place Place code
     * @param string $date Delivery date
     *
     * @return bool|array Return pickup data or false in case of an error
     * @throws \InvalidArgumentException
     */
    public function add($place, $date)
    {
        ArgValidator::assert($place, ['notEmpty']);
        ArgValidator::assert($date, ['notEmpty']);

        $args = [
            'zabors' => [
                'zabor' => [
                    'zabor_places_code' => $place,
                    'delivery_date' => $date
                ]
            ]
        ];

        if (!$this->callMethod('add_zabor', $args)) {
            return false;
        }

        $answerPickupData = $this->answer->getData()['zabors']['zabor'];

        if (isset($answerPickupData['error_code'])
            && $answerPickupData['error_code'] !== self::ADD_ERROR_NO) {
            $this->errorCode = (int)$answerPickupData['error_code'];
            return false;
        }

        return $answerPickupData;
    }

    /**
     * Add new pickup place
     *
     * @param array $placeData Place data
     * @param string $errorMessage Error message
     *
     * @return bool|string Return place code or false in case of an error
     * @throws \InvalidArgumentException
     */
    public function addPlace(array $placeData, &$errorMessage)
    {
        ArgValidator::arrayAssert($placeData, $this->requiredFieldsForAddPlace);

        if (!$this->callMethod('client_add_update_zabor_place', ['zabor_places' => ['zabor_place' => $placeData]])) {
            return false;
        }

        $answerPlaceData = $this->answer->getData()['zabor_places']['zabor_place'];

        if (!empty($answerPlaceData['msg'])) {
            $errorMessage = $answerPlaceData['msg'];
            return false;
        }

        return $answerPlaceData['code'];
    }
}