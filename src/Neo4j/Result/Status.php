<?php namespace EndyJasmi\Neo4j\Result;

class Status
{
    protected $status = array();

    public function __construct(array $status)
    {
        $this->status = $status;
    }

    public function __get($status)
    {
        return $this->status[static::convert($status)];
    }

    public static function convert($string)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }
}
