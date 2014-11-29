<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;

class Response extends Collection implements ResponseInterface
{
    use FactoryManagerTrait;

    /**
     * @var ErrorInterface
     */
    protected $error;

    /**
     * @var RequestInterface
     */
    protected $request;

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
    ) {
        $this->setFactory($factory)
            ->setRequest($request);

        $this->errors = $this->getFactory()
            ->createError($response['errors'], $throws);

        foreach ($response['results'] as $index => $result) {
            $statement = $request[$index];
            $result = $this->getFactory()
                ->createResult($statement, $result);

            $statement->setResult($result);
            $this->push($result);
        }
    }

    /**
     * Get error instance
     *
     * @return ErrorInterface
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get request instance
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set request instance
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }
}
