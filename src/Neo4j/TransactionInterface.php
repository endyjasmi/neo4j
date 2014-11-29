<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\DriverManagerInterface;
use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;
use InvalidArgumentException;

interface TransactionInterface extends DriverManagerInterface, FactoryManagerInterface
{
    /**
     * Transaction constructor
     *
     * @param FactoryInterface $factory
     * @param DriverInterface $driver
     * @param RequestInterface $request
     */
    public function __construct(FactoryInterface $factory, DriverInterface $driver, RequestInterface $request);

    /**
     * Commit transaction
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function commit(RequestInterface $request);

    /**
     * Execute transaction
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function execute(RequestInterface $request);

    /**
     * Get transaction id
     *
     * @return null|integer
     */
    public function getId();

    /**
     * Get transaction response
     *
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * Rollback transaction
     *
     * @return ResponseInterface
     */
    public function rollback();

    /**
     * Set transaction id
     *
     * @param null|integer $id
     * @return TransactionInterface
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function setId($id);
}
