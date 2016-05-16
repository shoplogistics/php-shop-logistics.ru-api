<?php


namespace Gxs\ShopLogisticsRu;


use Heartsentwined\ArgValidator\ArgValidator;
use Gxs\ShopLogisticsRu\Exception\AnswerException;

/**
 * Class ApiClass
 * @package ShopLogisticsRu
 */
class ApiClass
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
        ArgValidator::assert($apiKey, ['notEmpty']);
        ArgValidator::assert($environment, ['notEmpty']);
        $this->apiInstance = Api::getInstance($apiKey, $environment);
    }

    /**
     * Get last answer error code
     *
     * @return int|null Return error code
     */
    public function getLastErrorCode()
    {
        if ($this->answer !== null && $this->answer instanceof Answer)  {
            return $this->answer->getErrorCode();
        } elseif ($this->errorCode !== null) {
            $errorCode = $this->errorCode;
            $this->errorCode = null;
            
            return $errorCode;
        }

        return null;
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
}