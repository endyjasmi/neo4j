<?php namespace EndyJasmi\Neo4j;

use InvalidArgumentException;

class Statement extends Collection implements StatementInterface
{
    /**
     * @var ResultInterface
     */
    protected $result;

    /**
     * Statement constructor
     *
     * @param string $query
     * @param array $parameters
     * @throws InvalidArgumentException If $query is not string
     */
    public function __construct($query, array $parameters = [])
    {
        $this->setQuery($query)
            ->setParameters($parameters)
            ->put('includeStats', true);
    }

    /**
     * Get statement parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->get('parameters', []);
    }

    /**
     * Get statement query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->get('statement');
    }

    /**
     * Get result instance
     *
     * @return ResultInterface
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set statement parameters
     *
     * @param array $parameters
     * @return StatementInterface
     */
    public function setParameters(array $parameters)
    {
        $this->put('parameters', $parameters);

        return $this;
    }

    /**
     * Set statement query
     *
     * @param string $query
     * @return StatementInterface
     * @throws InvalidArgumentException If $query is not string
     */
    public function setQuery($query)
    {
        if (! is_string($query)) {
            throw new InvalidArgumentException('$query is not string.');
        }

        $this->put('statement', $query);

        return $this;
    }

    /**
     * Set result instance
     *
     * @param ResultInterface $result
     * @return StatementInterface
     */
    public function setResult(ResultInterface $result)
    {
        $this->result = $result;

        return $this;
    }
}
