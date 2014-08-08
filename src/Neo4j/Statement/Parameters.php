<?php namespace EndyJasmi\Neo4j\Statement;

class Parameters
{
    protected $parameters = array();

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function toArray()
    {
        $parameters = array();

        foreach ($this->parameters as $parameter => $value) {
            if (is_int($parameter)) {
                $parameter = "parameter_$parameter";
            }

            $parameters[$parameter] = $value;
        }

        return $parameters;
    }
}
