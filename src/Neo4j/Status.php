<?php namespace EndyJasmi\Neo4j;

class Status extends Collection implements StatusInterface
{
    /**
     * Status constructor
     *
     * @param array $status
     */
    public function __construct(array $status)
    {
        foreach ($status as $type => $value) {
            $this->put($type, $value);
        }
    }

    /**
     * Camel case getter
     *
     * @param string $parameter
     * @return null|mixed
     */
    public function __get($parameter)
    {
        $parameter = snake_case($parameter);

        return $this->get($parameter);
    }
}
