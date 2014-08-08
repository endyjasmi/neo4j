<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Statement\Parameters;
use EndyJasmi\Neo4j\Statement\Query;

class Statement
{
    protected $parameters;

    protected $query;

    public function __construct(Query $query, Parameters $parameters)
    {
        $this->query = $query;
        $this->parameters = $parameters;
    }

    public function toArray()
    {
        $statement = array();
        $statement['statement'] = (string) $this->query;
        $statement['parameters'] = $this->parameters->toArray();
        $statement['includeStats'] = true;

        if (empty($statement['parameters'])) {
            unset($statement['parameters']);
        }

        return $statement;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
