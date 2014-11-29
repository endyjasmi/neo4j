<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\DriverInterface;

trait DriverManagerTrait
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * Get driver instance
     *
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set driver instance
     *
     * @param DriverInterface $driver
     * @return DriverManagerInterface
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;

        return $this;
    }
}
