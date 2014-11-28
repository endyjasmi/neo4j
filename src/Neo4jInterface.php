<?php namespace EndyJasmi;

use EndyJasmi\Neo4j\DriverInterface;
use EndyJasmi\Neo4j\FactoryInterface;
use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;

interface Neo4jInterface extends FactoryManagerInterface
{
    /**
     * Neo4j constructor
     *
     * @param array $options
     * @param FactoryInterface $factory
     */
    public function __construct(array $options = [], FactoryInterface $factory = null);

    /**
     * Get a connection instance
     *
     * @param string $connection
     * @return ConnectionInterface
     */
    public function connection($connection = null);

    /**
     * Get a driver instance
     *
     * @param string $driver
     * @return DriverInterface
     */
    public function driver($driver = null);

    /**
     * Get neo4j options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Set neo4j options
     *
     * @param array $options
     * @return Neo4jInterface
     */
    public function setOptions(array $options);
}
