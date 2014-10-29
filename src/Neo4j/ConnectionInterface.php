<?php
/**
 * Connection interface file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Request\StatementInterface;
use EndyJasmi\Neo4j\Response\ErrorsInterface;
use EndyJasmi\Neo4j\Response\ResultInterface;
use EndyJasmi\Neo4j\Response\StatusInterface;

/**
 * ConnectionInterface is an interface for connection class
 */
interface ConnectionInterface
{
    /**
     * Begin a new transaction
     *
     * @param RequestInterface $request Transaction request
     *
     * @return ResponseInterface Return transaction response
     */
    public function beginTransaction(RequestInterface $request = null);

    /**
     * Commit a transaction
     *
     * @param RequestInterface $request Transaction request
     *
     * @return ResponseInterface Return transaction response
     */
    public function commit(RequestInterface $request);

    /**
     * Create response errors
     *
     * @param array $errors Response errors
     * @param boolean $throws Throw exception
     *
     * @return ErrorsInterface Return response errors
     */
    public function createErrors(array $errors, $throws = true);

    /**
     * Create transaction request
     *
     * @param integer $id Transaction id
     *
     * @return RequestInterface Return transaction request
     */
    public function createRequest($id = null);

    /**
     * Create transaction response
     *
     * @param RequestInterface $request Transaction request
     * @param array $response Array response return from server
     * @param integer $id Transaction id
     * @param boolean $throws Throws and exception if server return error
     *
     * @return ResponseInterface Return transaction response
     */
    public function createResponse(RequestInterface $request, array $response, $id = null, $throws = true);

    /**
     * Create a statement
     *
     * @param string $query Statement query
     * @param array $parameters Statement parameters
     *
     * @return StatementInterface Return statement
     */
    public function createStatement($query, array $parameters = []);

    /**
     * Create a status
     *
     * @param ResultInterface $result Status result
     * @param array $status Raw status
     *
     * @return StatusInterface Return status
     */
    public function createStatus(ResultInterface $result, array $status);

    /**
     * Execute an open transaction
     *
     * @param RequestInterface $request Transaction request
     *
     * @return ResponseInterface Return transaction response
     */
    public function execute(RequestInterface $request);

    /**
     * Rollback an open transaction
     *
     * @param RequestInterface $request Transaction request
     *
     * @return ResponseInterface Return transaction response
     */
    public function rollback(RequestInterface $request);

    /**
     * Run a general statement
     *
     * @param string $query Statement query
     * @param array $parameters Statement parameters
     *
     * @return ResultInterface Return result
     */
    public function statement($query, array $parameters = []);

    /**
     * Run a set of operation in database transaction
     *
     * @param callable $callable Set of database operation
     */
    public function transaction(callable $callable);
}
