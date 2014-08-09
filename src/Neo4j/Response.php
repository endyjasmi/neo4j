<?php namespace EndyJasmi\Neo4j;

use ArrayAccess;
use Countable;
use Iterator;
use EndyJasmi\Neo4j\Result;

class Response implements ArrayAccess, Countable, Iterator
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

    protected function result(array $result)
    {
        return new Result($result);
    }

    public function __construct(array $response)
    {
        if (!empty($response['errors'])) {
            throw $this->exception($response['errors'][0]);
        }

        $this->results = $response['results'];
    }

    public function toArray()
    {
        return array_map(
            function ($result) use ($this) {
                return $this->result($result)
                    ->toArray();
            },
            $this->results
        );
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function offsetGet($offset)
    {
        return $this->result($this->results[$offset]);
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

    protected $cursor = 0;

    public function current()
    {
        return $this->result($this->results[$this->cursor]);
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
}
