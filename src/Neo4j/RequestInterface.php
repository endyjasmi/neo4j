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
 * @todo Extend collection
 */
interface RequestInterface
{
    /**
     * Request constructor
     *
     * @param ConnectionInterface $connection Request connection
     * @param integer $id Transaction id
     */
    public function __construct(ConnectionInterface $connection, $id = null);

    /**
     * Begin a new transaction with this request
     *
     * @return ResponseInterface Return transaction response
     */
    public function beginTransaction();

    /**
     * Commit a transaction with this request
     *
     * @return ResponseInterface Return transaction response
     */
    public function commit();

    /**
     * Execute an open transaction with this request
     *
     * @return ResponseInterface Return transaction response
     */
    public function execute();

    /**
     * Get request connection
     *
     * @return ConnectionInterface Return connection
     */
    public function getConnection();

    /**
     * Get transaction id
     *
     * @return integer|null Return transaction id or null if not a transaction request
     */
    public function getId();

    /**
     * Get request response
     *
     * @return ResponseInterface|null Return response or null if not sent
     */
    public function getResponse();

    /**
     * Pop statement from the stack
     *
     * @return StatementInterface Return statement
     */
    public function popStatement();

    /**
     * Push statement into the stack
     *
     * @param StatementInterface $statement Request statement
     *
     * @return RequestInterface Return self
     */
    public function pushStatement(StatementInterface $statement);

    /**
     * Set request connection
     *
     * @param ConnectionInterface $connection Request connection
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
     * Set request response
     *
     * @param ResponseInterface $response Request response
     *
     * @return RequestInterface Return self
     */
    public function setResponse(ResponseInterface $response);

    /**
     * Create and push statement into the stack
     *
     * @param string $query Statement query
     * @param array $parameters Statement parameters
     *
     * @return RequestInterface Return self
     */
    public function statement($query, array $parameters = []);
}
