<?php


namespace Gxs\ShopLogisticsRu;


use Heartsentwined\ArgValidator\ArgValidator;
use Gxs\ShopLogisticsRu\Exception\AnswerException;

/**
 * Class ApiClass
 * @package ShopLogisticsRu
 */
abstract class ApiClass
{
    /**
     * Instance of Api class
     *
     * @var Api|null
     */
    protected $apiInstance = null;

    /**
     * Instance of Answer class
     *
     * @var Answer|null
     */
    protected $answer = null;

    /**
     * Error code
     * 
     * @var int
     */
    protected $errorCode;

    /**
     * ApiClass constructor.
     *
     * @param string $apiKey API Key
     * @param string $environment API Environment
     */
    public function __construct($apiKey, $environment)
    {
        ArgValidator::assert($apiKey, ['string', 'notEmpty']);
        ArgValidator::assert($environment, ['string', 'notEmpty']);
        $this->apiInstance = Api::getInstance($apiKey, $environment);
    }

    /**
     * ApiClass destructor.
     */
    public function __destruct()
    {
        $this->apiInstance = null;
        $this->answer = null;
    }

    /**
     * Get last answer error code
     *
     * @return int|null Return error code
     */
    public function getLastErrorCode()
    {
        if ($this->errorCode !== null) {
            $errorCode = $this->errorCode;
            $this->errorCode = null;

            return $errorCode;
        } elseif ($this->answer !== null && $this->answer instanceof Answer)  {
            return $this->answer->getErrorCode();
        } else {
            return null;
        }
    }

    /**
     * Check has error in answer
     *
     * @return bool
     */
    protected function hasError()
    {
        return $this->answer === null || !($this->answer instanceof Answer);
    }

    /**
     * Call method and get answer
     *
     * @param string $methodName Method name
     * @param array $arguments Method arguments
     *
     * @return bool Return tru if method call successfully or false otherwise
     */
    protected function callMethod($methodName, $arguments)
    {
        try {
            $this->answer = $this->apiInstance->callMethod($methodName, $arguments);
        } catch (AnswerException $e) {
            $this->answer = null;
        }

        return !$this->hasError();
    }

    /**
     * Return answer data as array list
     *
     * @param string $rootKey Root array key
     * @param string $itemKey Item array key
     *
     * @return array
     */
    protected function returnAsArrayList($rootKey, $itemKey)
    {
        if (!isset($this->answer[$rootKey][$itemKey]) || !is_array($this->answer[$rootKey][$itemKey])) {
            return [];
        }

        /** @var array $arrayList */
        $arrayList = $this->answer[$rootKey][$itemKey];

        if (!is_int(array_keys($arrayList)[0])) {
            $arrayList = [$arrayList];
        }

        return $arrayList;
    }
}