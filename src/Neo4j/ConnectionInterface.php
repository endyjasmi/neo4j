<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;

interface ConnectionInterface extends CollectionInterface, FactoryManagerInterface
{
    /**
     * Connection constructor
     *
     * @param FactoryInterface $factory
     * @param DriverInterface $driver
     */
    public function __construct(FactoryInterface $factory, DriverInterface $driver);

    /**
     * Begin transaction
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function beginTransaction(RequestInterface $request = null);

    /**
     * Commit transaction
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function commit(RequestInterface $request = null);

    /**
     * Create request instance
     *
     * @param integer $id
     * @return RequestInterface
     */
    public function createRequest($id = null);

    /**
     * Execute transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function execute(RequestInterface $request);

    /**
     * Get driver instance
     *
     * @return DriverInterface
     */
    public function getDriver();

    /**
     * Get last transaction instance
     *
     * @return null|ResponseInterface
     */
    public function getTransaction();

    /**
     * Pop transaction instance
     *
     * @return null|ResponseInterface
     */
    public function popTransaction();

    /**
     * Push transaction instance
     *
     * @param ResponseInterface $transaction
     * @return ConnectionInterface
     */
    public function pushTransaction(ResponseInterface $transaction);

    /**
     * Rollback transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function rollback(RequestInterface $request = null);

    /**
     * Set driver instance
     *
     * @param DriverInterface $driver
     * @return ConnectionInterface
     */
    public function setDriver(DriverInterface $driver);

    /**
     * Run statement
     *
     * @param string $query
     * @param array $parameters
     * @return ResultInterface
     * @throws InvalidArgumentException If $query is not string
     */
    public function statement($query, array $parameters = []);
}
