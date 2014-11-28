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
     * @param integer $id
     * @param boolean $throws
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function __construct(
        FactoryInterface $factory,
        ConnectionInterface $connection,
        RequestInterface $request,
        array $response,
        $id = null,
        $throws = true
    );

    /**
     * Get error instance
     *
     * @return ErrorInterface
     */
    public function getErrors();

    /**
     * Get response id
     *
     * @return null|integer
     */
    public function getId();

    /**
     * Get request instance
     *
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * Set response id
     *
     * @param null|integer $id
     * @return ResponseInterface
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function setId($id);

    /**
     * Set request instance
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function setRequest(RequestInterface $request);
}
