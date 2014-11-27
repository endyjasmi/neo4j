<?php namespace EndyJasmi\Neo4j;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;

interface CollectionInterface extends ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    /**
     * Get an item by key
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key);

    /**
     * Get and remove the last item
     *
     * @return mixed
     */
    public function pop();

    /**
     * Push an item to the end
     *
     * @param mixed $item
     */
    public function push($item);

    /**
     * Push an item by key
     *
     * @param mixed $key
     * @param mixed $item
     */
    public function put($key, $item);

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray();

    /**
     * Convert to json string
     *
     * @param integer $options
     * @return string
     */
    public function toJson($options = 0);
}
