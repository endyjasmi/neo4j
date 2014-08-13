<?php namespace EndyJasmi\Neo4j;

use ArrayAccess;
use Countable;
use EndyJasmi\Neo4j\Result;
use Exception;
use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Support\Contracts\JsonableInterface;
use Iterator;

class Response implements ArrayableInterface, ArrayAccess, Countable, Iterator, JsonableInterface
{
    protected $results = array();

    protected function exception($error)
    {
        $exception = $this->exceptionClass($error['code']);

        return new $exception($error['message']);
    }

    protected function exceptionClass($code)
    {
        $class = str_replace('.', '\\', $code);

        return "EndyJasmi\\Neo4j\\StatusCodes\\$class";
    }

    public function __construct(array $response)
    {
        if (!empty($response['errors'])) {
            throw $this->exception($response['errors'][0]);
        }

        $this->results = $response['results'];
    }

    public function createResult(array $result)
    {
        return new Result($result);
    }

    // Implement ArrayableInterface
    public function toArray()
    {
        $that = $this;
        return array_map(
            function ($result) use ($that) {
                return $that->createResult($result)
                    ->toArray();
            },
            $this->results
        );
    }

    // Implement ArrayAccess
    public function offsetGet($offset)
    {
        return $this->createResult($this->results[$offset]);
    }

    public function offsetExists($offset)
    {
        return isset($this->results[$offset]);
    }

    public function offsetSet($offset, $value)
    {
        throw new Exception('Invalid operation');
    }

    public function offsetUnset($offset)
    {
        throw new Exception('Invalid operation');
    }

    public function count()
    {
        return count($this->results);
    }

    // Implement Iterator
    protected $cursor = 0;

    public function current()
    {
        return $this->createResult($this->results[$this->cursor]);
    }

    public function key()
    {
        return $this->cursor;
    }

    public function rewind()
    {
        $this->cursor = 0;
    }

    public function next()
    {
        $this->cursor++;
    }

    public function valid()
    {
        return isset($this->results[$this->cursor]);
    }

    // Implement JsonableInterface
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
