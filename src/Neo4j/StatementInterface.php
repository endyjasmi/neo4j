<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;
use InvalidArgumentException;

interface StatementInterface extends CollectionInterface, FactoryManagerInterface
{
    /**
     * Statement constructor
     *
     * @param FactoryInterface $factory
     * @param string $query
     * @param array $parameters
     * @throws InvalidArgumentException If $query is not string
     */
    public function __construct(FactoryInterface $factory, $query, array $parameters = []);

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
     * Get statement tile
     *
     * @return null|float
     */
    public function getTime();

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
     * Start timer
     *
     * @return StatementInterface
     */
    public function startTimer();

    /**
     * Stop timer
     *
     * @return StatementInterface
     */
    public function stopTimer();
}
