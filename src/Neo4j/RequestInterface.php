<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\ConnectionManagerInterface;
use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;
use EndyJasmi\Neo4j\Manager\TransactionManagerInterface;
use InvalidArgumentException;

interface RequestInterface extends
    ConnectionManagerInterface,
    CollectionInterface,
    FactoryManagerInterface,
    TransactionManagerInterface
{
    /**
     * Request constructor
     *
     * @param FactoryInterface $factory
     * @param ConnectionInterface $connection
     * @param TransactionInterface $transaction
     */
    public function __construct(
        FactoryInterface $factory,
        ConnectionInterface $connection,
        TransactionInterface $transaction
    );

    /**
     * Begin transaction
     *
     * @return ResponseInterface
     */
    public function beginTransaction();

    /**
     * Commit transaction
     *
     * @return ResponseInterface
     */
    public function commit();

    /**
     * Execute transaction
     *
     * @return ResponseInterface
     */
    public function execute();

    /**
     * Get response instace
     *
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * Pop statement instance
     *
     * @return StatementInterface
     */
    public function popStatement();

    /**
     * Push statement instance
     *
     * @param StatementInterface
     * @return RequestInterface
     */
    public function pushStatement(StatementInterface $statement);

    /**
     * Set response instance
     *
     * @param ResponseInterface
     * @return RequestInterface
     */
    public function setResponse(ResponseInterface $response);

    /**
     * Create and push statement into request
     *
     * @param string $query
     * @param array $parameters
     * @return RequestInterface
     * @throws InvalidArgumentException If $query is not string
     */
    public function statement($query, array $parameters = []);
}
