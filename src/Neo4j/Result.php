<?php namespace EndyJasmi\Neo4j;

use ArrayAccess;
use Countable;
use Iterator;
use EndyJasmi\Neo4j\Result\Status;

class Result implements ArrayAccess, Countable, Iterator
{
    protected $columns = array();

    protected $data = array();

    protected $status = array();

    protected function combine(array $columns, array $data)
    {
        return array_combine($columns, $data);
    }

    public function __construct(array $result)
    {
        $this->columns = $result['columns'];
        $this->data = $result['data'];
        $this->status = $result['stats'];
    }

    public function getStatus()
    {
        return new Status($this->status);
    }

    public function toArray()
    {
        return array_map(
            function ($row) {
                return $this->combine($this->columns, $row['row']);
            },
            $this->data
        );
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->combine($this->columns, $this->data[$offset]['row']);
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
        return count($this->data);
    }

    protected $cursor = 0;

    public function current()
    {
        return $this->combine($this->columns, $this->data[$this->cursor]['row']);
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
        return isset($this->data[$this->cursor]);
    }
}
