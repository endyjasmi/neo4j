<?php namespace EndyJasmi\Neo4j\Statement;

class Query
{
    protected $query;

    protected static function parse($query, $index = 0)
    {
        if ($position = strpos($query, '?')) {
            $replace = "{parameter_$index}";
            $query = substr_replace($query, $replace, $position, 1);
            $query = static::parse($query, ++$index);
        }

        return $query;
    }

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function __toString()
    {
        return static::parse($this->query);
    }
}
