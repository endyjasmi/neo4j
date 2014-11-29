<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerInterface;

interface ResponseInterface extends CollectionInterface, FactoryManagerInterface
{
    /**
     * Response constructor
     *
     * @param FactoryInterface $factory
     * @param RequestInterface $request
     * @param array $response
     * @param boolean $throws
     */
    public function __construct(
        FactoryInterface $factory,
        RequestInterface $request,
        array $response,
        $throws = true
    );

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
     * Set request instance
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function setRequest(RequestInterface $request);
}
