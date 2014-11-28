<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;

interface ErrorInterface extends CollectionInterface, FactoryManagerInterface
{
    /**
     * Error constructor
     *
     * @param FactoryInterface $factory
     * @param array $errors
     * @param boolean $throws
     * @throws Neo If $errors is not empty and $throws is true
     */
    public function __construct(FactoryInterface $factory, array $errors, $throws = true);
}
