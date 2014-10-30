<?php
/**
 * Response interface file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use DomainException;
use EndyJasmi\Neo4j\Response\ErrorsInterface;

/**
 * ResponseInterface is an interface for response class
 */
interface ResponseInterface
{
    /**
     * Response constructor
     *
     * @param ConnectionInterface $connection Connection instance
     * @param RequestInterface $request Request instance
     * @param array $response Response array
     * @param boolean $throws Auto throws exception
     */
    public function __construct(
        ConnectionInterface $connection,
        RequestInterface $request,
        array $response,
        $throws = true
    );

    /**
     * Commit an open transaction
     *
     * @return ResponseInterface Return response instance
     *
     * @throws DomainException If transaction id not set
     */
    public function commit();

    /**
     * Create request instance
     *
     * @return RequestInstance Return request instance
     */
    public function createRequest();

    /**
     * Get connection instance
     *
     * @return ConnectionInterface Return connection instance
     */
    public function getConnection();

    /**
     * Get errors instance
     *
     * @return ErrorsInterface Return errors instance
     */
    public function getErrors();

    /**
     * Get transaction id
     *
     * @return null|integer Return null or transaction id if set
     */
    public function getId();

    /**
     * Get request instance
     *
     * @return RequestInterface Return request instance
     */
    public function getRequest();

    /**
     * Rollback an open transaction
     *
     * @return ResponseInterface Return response instance
     *
     * @throws DomainException If transaction id not set
     */
    public function rollback();

    /**
     * Set connection instance
     *
     * @param ConnectionInterface $connection Connection instance
     *
     * @return ResponseInterface Return self
     */
    public function setConnection(ConnectionInterface $connection);

    /**
     * Set transaction id
     *
     * @param integer $id Transaction id
     *
     * @return ResponseInterface Return self
     */
    public function setId($id);

    /**
     * Set request instance
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return self
     */
    public function setRequest(RequestInterface $request);

    /**
     * Run a single statement
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     *
     * @return ResultInterface Return result instance
     */
    public function statement($query, array $parameters = []);
}
