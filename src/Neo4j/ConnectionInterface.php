<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\DriverManagerInterface;
use EndyJasmi\Neo4j\Manager\EventManagerInterface;
use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;
use InvalidArgumentException;

interface ConnectionInterface extends
    CollectionInterface,
    DriverManagerInterface,
    EventManagerInterface,
    FactoryManagerInterface
{
    /**
     * Connection constructor
     *
     * @param FactoryInterface $factory
     * @param EventInterface $event
     * @param DriverInterface $driver
     */
    public function __construct(FactoryInterface $factory, EventInterface $event, DriverInterface $driver);

    /**
     * Begin transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function beginTransaction(RequestInterface $request = null);

    /**
     * Commit transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function commit(RequestInterface $request = null);

    /**
     * Create request instance
     *
     * @return RequestInterface
     */
    public function createRequest();

    /**
     * Execute transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function execute(RequestInterface $request);

    /**
     * Get last transaction instance
     *
     * @return TransactionInterface
     */
    public function getTransaction();

    /**
     * Listen to query events
     *
     * @param callable $callback
     * @return ConnectionInterface
     */
    public function listen(callable $callback);

    /**
     * Pop transaction instance
     *
     * @return null|TransactionInterface
     */
    public function popTransaction();

    /**
     * Push transaction instance
     *
     * @param TransactionInterface $transaction
     * @return ConnectionInterface
     */
    public function pushTransaction(TransactionInterface $transaction);

    /**
     * Rollback transaction
     */
    public function rollback();

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
