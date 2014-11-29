<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\DriverInterface;

interface DriverManagerInterface
{
    /**
     * Get driver instance
     *
     * @return DriverInterface
     */
    public function getDriver();

    /**
     * Set driver instance
     *
     * @param DriverInterface $driver
     * @return DriverManagerInterface
     */
    public function setDriver(DriverInterface $driver);
}
