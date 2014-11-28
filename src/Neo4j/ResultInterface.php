<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;

interface ResultInterface extends CollectionInterface, FactoryManagerInterface
{
    /**
     * Result constructor
     *
     * @param FactoryInterface $factory
     * @param StatementInterface $statement
     * @param array $result
     */
    public function __construct(FactoryInterface $factory, StatementInterface $statement, array $result);

    /**
     * Get statement instance
     *
     * @return StatementInterface
     */
    public function getStatement();


    /**
     * Get status instance
     *
     * @return StatusInterface
     */
    public function getStatus();

    /**
     * Set statement instance
     *
     * @param StatementInterface $statement
     * @return ResultInterface
     */
    public function setStatement(StatementInterface $statement);
}
