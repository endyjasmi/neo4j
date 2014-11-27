<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\FactoryInterface;

interface FactoryManagerInterface
{
    /**
     * Get factory instance
     *
     * @return FactoryInterface
     */
    public function getFactory();

    /**
     * Set factory instance
     *
     * @param FactoryInterface $factory
     * @return FactoryManagerInterface
     */
    public function setFactory(FactoryInterface $factory);
}
