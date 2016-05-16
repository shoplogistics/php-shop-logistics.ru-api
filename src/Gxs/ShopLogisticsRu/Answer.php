<?php


namespace Gxs\ShopLogisticsRu;


use Gxs\ShopLogisticsRu\Exception\AnswerException;

/**
 * Class Answer
 * @package ShopLogisticsRu
 */
class Answer
{
    const ERROR_NO = 0;
    const ERROR_NOT_FOUND_CLIENT = 1;
    const ERROR_CALL_UNDEFINED_FUNCTION = 2;

    /**
     * Error code
     *
     * @var int
     */
    protected $errorCode;

    /**
     * Answer data
     *
     * @var array|null
     */
    protected $answerData = null;

    /**
     * Answer constructor.
     *
     * @param array $answer Answer array
     *
     * @throws AnswerException
     */
    public function __construct(array $answer)
    {
        if (!isset($answer['error'])) {
            throw new AnswerException('Invalid answer status');
        }

        $this->errorCode = (int)$answer['error'];
        unset($answer['error']);

        if (count($answer) > 0) {
            $this->answerData = [];

            foreach ($answer as $item) {
                $this->answerData[] = $item;
            }
        }
    }

    /**
     * Get error code
     * 
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Get answer data
     * 
     * @return array|null
     */
    public function getData()
    {
        return $this->answerData;
    }

    /**
     * Check has error in answer
     * 
     * @return bool
     */
    public function hasError()
    {
        return $this->errorCode !== static::ERROR_NO;
    }
}