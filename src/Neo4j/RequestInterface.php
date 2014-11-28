<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\ConnectionManagerInterface;
use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;
use InvalidArgumentException;

interface RequestInterface extends ConnectionManagerInterface, CollectionInterface, FactoryManagerInterface
{
    /**
     * Request constructor
     *
     * @param FactoryInterface $factory
     * @param ConnectionInterface $connection
     * @param null|integer $id
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function __construct(FactoryInterface $factory, ConnectionInterface $connection, $id = null);

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
     * Get request id
     *
     * @return null|integer
     */
    public function getId();

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
     * Set request id
     *
     * @param null|integer $id
     * @return RequestInterface
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function setId($id);

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
