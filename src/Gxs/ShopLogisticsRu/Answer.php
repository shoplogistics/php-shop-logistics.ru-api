<?php


namespace Gxs\ShopLogisticsRu;


use Gxs\ShopLogisticsRu\Exception\AnswerException;

/**
 * Class Answer
 * @package ShopLogisticsRu
 */
class Answer implements \Iterator, \ArrayAccess
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
     * @var array
     */
    protected $answerData = [];

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
            $this->answerData = $answer;
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
     * Check has error in answer
     * 
     * @return bool
     */
    public function hasError()
    {
        return $this->errorCode !== static::ERROR_NO;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->answerData);
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        next($this->answerData);
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->answerData);
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->answerData[$this->key()]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->answerData);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->answerData[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->answerData[$offset] : null;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->answerData[] = $value;
        } else {
            $this->answerData[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->answerData[$offset]);
    }

    /**
     * Copy answer to array
     *
     * @return array
     */
    public function toArray()
    {
        return iterator_to_array($this);
    }
}