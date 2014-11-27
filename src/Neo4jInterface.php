<?php namespace EndyJasmi;

use EndyJasmi\Neo4j\DriverInterface;

interface Neo4jInterface
{
    /**
     * Neo4j constructor
     *
     * @param array $options
     */
    public function __construct(array $options = []);

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
