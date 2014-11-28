<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;
use InvalidArgumentException;

class Connection extends Collection implements ConnectionInterface
{
    use FactoryManagerTrait;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var array
     */
    protected $transaction = [];

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

        $this->pushTransaction($response);

        return $response;
    }

    /**
     * Commit transaction
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function commit(RequestInterface $request = null)
    {
        $request = $request ?: $this->createRequest();

        $input = $request->toArray();
        $id = $request->getId();

        $output = $this->getDriver()
            ->commit($input, $id);

        list($id, $response) = $output;

        $response = $this->createResponse($request, $response);
        $request->setResponse($response);

        $this->popTransaction();

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
        $transaction = $this->getTransaction();

        if (is_null($id) && ! is_null($transaction)) {
            $id = $transaction->getId();
        }

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
     * Fire event listener
     *
     * @param string $query
     * @param array $parameters
     * @param float $time
     * @throws InvalidArgumentException If $query is not string
     * @throws InvalidArgumentException If $time is not float
     */
    public function fire($query, array $parameters, $time)
    {
        if (! is_string($query)) {
            throw new InvalidArgumentException('$query is not string.');
        }

        if (! is_float($time)) {
            throw new InvalidArgumentException('$time is not float.');
        }

        $container = $this->getFactory()
            ->getContainer();

        $container['events']->fire('neo4j.query', [$query, $parameters, $time]);
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
     * Get last transaction instance
     *
     * @return null|ResponseInterface
     */
    public function getTransaction()
    {
        return $this->last();
    }

    /**
     * Listen to event
     *
     * @param callable $listener
     * @return ConnectionInterface
     */
    public function listen(callable $listener)
    {
        $container = $this->getFactory()
            ->getContainer();

        $container['events']->listen('neo4j.query', $listener);
    }

    /**
     * Pop transaction instance
     *
     * @return null|ResponseInterface
     */
    public function popTransaction()
    {
        return $this->pop();
    }

    /**
     * Push transaction instance
     *
     * @param ResponseInterface $transaction
     * @return ConnectionInterface
     */
    public function pushTransaction(ResponseInterface $transaction)
    {
        $this->push($transaction);

        return $this;
    }

    /**
     * Rollback transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function rollback(RequestInterface $request = null)
    {
        $request = $request ?: $this->createRequest();

        $id = $request->getId();

        $output = $this->getDriver()
            ->rollback($id);

        list($id, $response) = $output;

        $response = $this->createResponse($request, $response);
        $request->setResponse($response);

        $this->popTransaction();

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
        $transaction = $this->getTransaction();

        $statement = $this->getFactory()
            ->createStatement($query, $parameters);

        $request = $this->createRequest()
            ->pushStatement($statement);

        if (is_null($transaction)) {
            $request->commit();
        } else {
            $request->execute();
        }

        return $statement->getResult();
    }
}
