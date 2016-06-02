<?php


namespace Gxs\ShopLogisticsRu;

use Gxs\ShopLogisticsRu\Exception\NotImplementedException;

/**
 * Class MailDelivery
 * @package ShopLogisticsRu
 */
class MailDelivery extends ApiClass
{
    /**
     * Add new mail delivery
     *
     * @param array $mailDeliveryData Mail delivery data
     *
     * @throws NotImplementedException
     */
    public function add(array $mailDeliveryData)
    {
        throw new NotImplementedException(__CLASS__, __METHOD__);
    }

    /**
     * Get mail deliveries list by filter
     *
     * @param array $filter Filter
     *
     * @throws NotImplementedException
     */
    public function getDeliveries(array $filter)
    {
        throw new NotImplementedException(__CLASS__, __METHOD__);
    }

    /**
     * Get mail deliveries by code or codes
     *
     * @param string|array $code Code or codes of deliveries
     *
     * @throws NotImplementedException
     */
    public function getDeliveriesByCode($code)
    {
        throw new NotImplementedException(__CLASS__, __METHOD__);
    }

    /**
     * Get delivery tariffs
     *
     * @param array $parameters Parameters
     *
     * @throws NotImplementedException
     */
    public function getTariffs(array $parameters)
    {
        throw new NotImplementedException(__CLASS__, __METHOD__);
    }
}