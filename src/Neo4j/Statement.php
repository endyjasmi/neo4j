<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;
use InvalidArgumentException;

class Statement extends Collection implements StatementInterface
{
    use FactoryManagerTrait;

    /**
     * @var ResultInterface
     */
    protected $result;

    /**
     * @var TimerInterface
     */
    protected $timer;

    /**
     * Statement constructor
     *
     * @param FactoryInterface $factory
     * @param TimerInterface $timer
     * @param string $query
     * @param array $parameters
     * @throws InvalidArgumentException If $query is not string
     */
    public function __construct(FactoryInterface $factory, TimerInterface $timer, $query, array $parameters = [])
    {
        $this->setFactory($factory)
            ->setTimer($timer)
            ->setQuery($query)
            ->setParameters($parameters)
            ->put('includeStats', true);

        $this->getTimer()
            ->start();
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
     * Get timer instance
     *
     * @return TimerInterface
     */
    public function getTimer()
    {
        return $this->timer;
    }

    /**
     * Set statement parameters
     *
     * @param array $parameters
     * @return StatementInterface
     */
    public function setParameters(array $parameters)
    {
        if (count($parameters)) {
            $this->put('parameters', $parameters);
        }

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

        $this->put('statement', trim($query));

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

        $this->getTimer()
            ->stop();

        return $this;
    }

    /**
     * Set timer instance
     *
     * @param TimerInterface $timer
     * @return StatementInterface
     */
    public function setTimer(TimerInterface $timer)
    {
        $this->timer = $timer;

        return $this;
    }
}
