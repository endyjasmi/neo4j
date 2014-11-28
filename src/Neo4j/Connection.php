<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;

class Connection implements ConnectionInterface
{
    use FactoryManagerTrait;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * Create response instance
     *
     * @param RequestInterface $request
     * @param array $response
     * @param integer $id
     * @param boolean $throws
     */
    protected function createResponse(
        RequestInterface $request,
        array $response,
        $id = null,
        $throws = true
    ) {
        return $this->getFactory()
            ->createResponse($this, $request, $response, $id, $throws);
    }

    /**
     * Connection constructor
     *
     * @param FactoryInterface $factory
     * @param DriverInterface $driver
     */
    public function __construct(FactoryInterface $factory, DriverInterface $driver)
    {
        $this->setFactory($factory)
            ->setDriver($driver);
    }

    /**
     * Begin transaction
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function beginTransaction(RequestInterface $request = null)
    {
        $request = $request ?: $this->createRequest();

        $input = $request->toArray();

        $output = $this->getDriver()
            ->beginTransaction($input);

        list($id, $response) = $output;

        $response = $this->createResponse($request, $response, $id);
        $request->setResponse($response);

        return $response;
    }

    /**
     * Commit transaction
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function commit(RequestInterface $request)
    {
        $input = $request->toArray();
        $id = $request->getId();

        $output = $this->getDriver()
            ->commit($input, $id);

        list($id, $response) = $output;

        $response = $this->createResponse($request, $response, $id);
        $request->setResponse($response);

        return $response;
    }

    /**
     * Create request instance
     *
     * @param integer $id
     * @return RequestInterface
     */
    public function createRequest($id = null)
    {
        return $this->getFactory()
            ->createRequest($this, $id);
    }

    /**
     * Execute transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function execute(RequestInterface $request)
    {
        $input = $request->toArray();
        $id = $request->getId();

        $output = $this->getDriver()
            ->execute($input, $id);

        list($id, $response) = $output;

        $response = $this->createResponse($request, $response, $id);
        $request->setResponse($response);

        return $response;
    }

    /**
     * Get driver instance
     *
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Rollback transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function rollback(RequestInterface $request)
    {
        $id = $request->getId();

        $output = $this->getDriver()
            ->rollback($id);

        list($id, $response) = $output;

        $response = $this->createResponse($request, $response, $id);
        $request->setResponse($response);

        return $response;
    }

    /**
     * Set driver instance
     *
     * @param DriverInterface $driver
     * @return ConnectionInterface
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Run statement
     *
     * @param string $query
     * @param array $parameters
     * @return ResultInterface
     * @throws InvalidArgumentException If $query is not string
     */
    public function statement($query, array $parameters = [])
    {
        $statement = $this->getFactory()
            ->createStatement($query, $parameters);

        $this->createRequest()
            ->pushStatement($statement)
            ->commit();

        return $statement->getResult();
    }
}
