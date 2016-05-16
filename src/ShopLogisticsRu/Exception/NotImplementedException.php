<?php


namespace ShopLogisticsRu\Exception;

/**
 * Class NotImplementedException
 * @package ShopLogisticsRu\Exception
 */
class NotImplementedException extends \Exception
{
    public function __construct($class, $method)
    {
        parent::__construct(sprintf('%s::%s', $class, $method));
    }
}