<?php namespace EndyJasmi\Neo4j;

use ArrayAccess;
use Countable;
use EndyJasmi\Neo4j\Result\Status;
use Exception;
use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Support\Contracts\JsonableInterface;
use Iterator;

class Result implements ArrayableInterface, ArrayAccess, Countable, Iterator, JsonableInterface
{
    protected $columns = array();

    protected $data = array();

    protected $status = array();

    public function __construct(array $result)
    {
        $this->columns = $result['columns'];
        $this->data = $result['data'];
        $this->status = $result['stats'];
    }

    public function combine(array $columns, array $data)
    {
        return array_combine($columns, $data);
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getStatus()
    {
        return new Status($this->status);
    }

    // Implement ArrayableInterface
    public function toArray()
    {
        $that = $this;
        return array_map(
            function ($row) use ($that) {
                return $that->combine($that->getColumns(), $row['row']);
            },
            $this->data
        );
    }

    // Implement ArrayAccess
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

    // Implement Countable
    public function count()
    {
        return count($this->data);
    }

    // Implement Iterator
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

    // Implement JsonableInterface
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
