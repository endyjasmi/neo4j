<?php
/**
 * Request interface file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Request\StatementInterface;

/**
 * RequestInterface is an interface for request class
 */
interface RequestInterface
{
    /**
     * Request constructor
     *
     * @param ConnectionInterface $connection Connection instance
     * @param integer $id Transaction id
     */
    public function __construct(ConnectionInterface $connection, $id = null);

    /**
     * Begin a new transaction
     *
     * @return ResponseInterface Return transaction response
     */
    public function beginTransaction();

    /**
     * Commit a transaction
     *
     * @return ResponseInterface Return transaction response
     */
    public function commit();

    /**
     * Execute an open transaction
     *
     * @return ResponseInterface Return transaction response
     */
    public function execute();

    /**
     * Get connection instance
     *
     * @return ConnectionInterface Return connection instance
     */
    public function getConnection();

    /**
     * Get transaction id
     *
     * @return null|integer Return null or transaction id if set
     */
    public function getId();

    /**
     * Get response instance
     *
     * @return null|ResponseInterface Return null or response instance if set
     */
    public function getResponse();

    /**
     * Pop statement instance from collection
     *
     * @return StatementInterface Return statement instance
     */
    public function popStatement();

    /**
     * Push statement instance into the collection
     *
     * @param StatementInterface $statement Statement instance
     *
     * @return RequestInterface Return self
     */
    public function pushStatement(StatementInterface $statement);

    /**
     * Set connection instance
     *
     * @param ConnectionInterface $connection Connection instance
     *
     * @return RequestInterface Return self
     */
    public function setConnection(ConnectionInterface $connection);

    /**
     * Set transaction id
     *
     * @param integer $id Transaction id
     *
     * @return RequestInterface Return self
     */
    public function setId($id);

    /**
     * Set response instance
     *
     * @param ResponseInterface $response Response instance
     *
     * @return RequestInterface Return self
     */
    public function setResponse(ResponseInterface $response);

    /**
     * Create and push statement into the stack
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     *
     * @return RequestInterface Return self
     */
    public function statement($query, array $parameters = []);

    /**
     * Convert request to array
     *
     * @return array Return request array
     */
    public function toArray();
}
