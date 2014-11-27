<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\FactoryInterface;

trait FactoryManagerTrait
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * Get factory instance
     *
     * @return FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Set factory instance
     *
     * @param FactoryInterface $factory
     * @return FactoryManagerInterface
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;

        return $this;
    }
}
