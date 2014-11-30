<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\EventManagerInterface;
use InvalidArgumentException;

interface StatementInterface extends CollectionInterface, EventManagerInterface
{
    /**
     * Statement constructor
     *
     * @param EventInterface $event
     * @param TimerInterface $timer
     * @param string $query
     * @param array $parameters
     * @throws InvalidArgumentException If $query is not string
     */
    public function __construct(EventInterface $event, TimerInterface $timer, $query, array $parameters = []);

    /**
     * Get statement parameters
     *
     * @return array
     */
    public function getParameters();

    /**
     * Get statement query
     *
     * @return string
     */
    public function getQuery();

    /**
     * Get result instance
     *
     * @return ResultInterface
     */
    public function getResult();

    /**
     * Get timer instance
     *
     * @return TimerInterface
     */
    public function getTimer();

    /**
     * Set statement parameters
     *
     * @param array $parameters
     * @return StatementInterface
     */
    public function setParameters(array $parameters);

    /**
     * Set statement query
     *
     * @param string $query
     * @return StatementInterface
     * @throws InvalidArgumentException If $query is not string
     */
    public function setQuery($query);

    /**
     * Set result instance
     *
     * @param ResultInterface $result
     * @return StatementInterface
     */
    public function setResult(ResultInterface $result);

    /**
     * Set timer instance
     *
     * @param TimerInterface $timer
     * @return StatementInterface
     */
    public function setTimer(TimerInterface $timer);
}
