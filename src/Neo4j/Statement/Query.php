<?php namespace EndyJasmi\Neo4j\Statement;

class Query
{
    protected $query;

    protected static function parseNamed($query)
    {
        return preg_replace('/:([a-z0-9_]+) /i', '{$1} ', $query);
    }

    protected static function parseUnamed($query, $index = 0)
    {
        if ($position = strpos($query, '?')) {
            $replace = "{parameter_$index}";
            $query = substr_replace($query, $replace, $position, 1);
            $query = static::parseUnamed($query, ++$index);
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

    public static function parse($query)
    {
        return static::parseNamed(static::parseUnamed($query));
    }
}
