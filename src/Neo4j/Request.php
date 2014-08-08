<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Statement;

class Request
{
    protected $statements = array();

    public function addStatement(Statement $statement)
    {
        $this->statements[] = $statement;

        return $this;
    }

    public function toArray()
    {
        return array_map(
            function ($statement) {
                return $statement->toArray();
            },
            $this->statements
        );
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
