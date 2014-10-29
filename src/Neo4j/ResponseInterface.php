<?php
/**
 * Response interface file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Response\ErrorsInterface;

/**
 * ResponseInterface is an interface for response class
 * @todo Extend collection
 */
interface ResponseInterface
{
    /**
     * Response constructor which auto set request response
     *
     * @param ConnectionInterface $connection Response connection
     * @param RequestInterface $request Response request
     * @param array $response Raw response
     * @param integer $id Transaction id
     * @param boolean $throws Throws error exception
     */
    public function __construct(
        ConnectionInterface $connection,
        RequestInterface $request,
        array $response,
        $id = null,
        $throws = true
    );

    /**
     * Get response connection
     *
     * @return ConnectionInterface Return response connection
     */
    public function getConnection();

    /**
     * Get response errors
     *
     * @return ErrorsInterface Return response errors
     */
    public function getErrors();

    /**
     * Get transaction id
     *
     * @return integer|null Return transaction id or null if not a transaction response
     */
    public function getId();

    /**
     * Get response request
     *
     * @return RequestInterface Return response request
     */
    public function getRequest();

    /**
     * Set response connection
     *
     * @param ConnectionInterface $connection Response connection
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
     * Set response request
     *
     * @param RequestInterface $request Response request
     *
     * @return ResponseInterface Return self
     */
    public function setRequest(RequestInterface $request);
}
