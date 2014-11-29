<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\ConnectionManagerInterface;
use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;
use InvalidArgumentException;

interface ResponseInterface extends ConnectionManagerInterface, CollectionInterface, FactoryManagerInterface
{
    /**
     * Response constructor
     *
     * @param FactoryInterface $factory
     * @param ConnectionInterface $connection
     * @param RequestInterface $request
     * @param array $response
     * @param boolean $throws
     */
    public function __construct(
        FactoryInterface $factory,
        ConnectionInterface $connection,
        RequestInterface $request,
        array $response,
        $throws = true
    );

    /**
     * Commit transaction
     *
     * @return ResponseInterface
     */
    public function commit();

    /**
     * Create request instance
     *
     * @return RequestInterface
     */
    public function createRequest();

    /**
     * Get error instance
     *
     * @return ErrorInterface
     */
    public function getErrors();

    /**
     * Get request instance
     *
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * Rollback transaction
     *
     * @return ResponseInterface
     */
    public function rollback();

    /**
     * Set request instance
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function setRequest(RequestInterface $request);

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
