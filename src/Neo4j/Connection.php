<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\DriverManagerTrait;
use EndyJasmi\Neo4j\Manager\EventManagerTrait;
use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;
use InvalidArgumentException;

class Connection extends Collection implements ConnectionInterface
{
    use DriverManagerTrait;
    use EventManagerTrait;
    use FactoryManagerTrait;

    /**
     * Send request without transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function send(RequestInterface $request)
    {
        $input = $request->toArray();
        $output = $this->getDriver()
            ->commit($input);

        list($id, $response) = $output;

        return $this->getFactory()
            ->createResponse($request, $response);
    }

    /**
     * Connection constructor
     *
     * @param FactoryInterface $factory
     * @param DriverInterface $driver
     * @param EventInterface $event
     */
    public function __construct(FactoryInterface $factory, DriverInterface $driver, EventInterface $event)
    {
        $this->setFactory($factory)
            ->setDriver($driver)
            ->setEvent($event);
    }

    /**
     * Begin transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function beginTransaction(RequestInterface $request = null)
    {
        // Initialize
        $driver = $this->getDriver();
        $request = $request ?: $this->createRequest();

        // Begin transaction
        $transaction = $this->getFactory()
            ->createTransaction($driver, $request);

        // Push to stack
        $this->pushTransaction($transaction);

        // Return last transaction response
        return $transaction->getResponse();
    }

    /**
     * Commit transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function commit(RequestInterface $request = null)
    {
        // Initialize
        $request = $request ?: $this->createRequest();
        $transaction = $this->popTransaction();

        // Commit transaction
        if (! is_null($transaction)) {
            return $transaction->commit($request);
        }

        // If not send single request commit
        return $this->send($request);
    }

    /**
     * Create request instance
     *
     * @return RequestInterface
     */
    public function createRequest()
    {
        return $this->getFactory()
            ->createRequest($this);
    }

    /**
     * Execute transaction
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function execute(RequestInterface $request)
    {
        // Initialize
        $transaction = $this->getTransaction();

        // Execute transaction
        if (! is_null($transaction)) {
            return $transaction->execute($request);
        }

        // If not send single request commit
        return $this->send($request);
    }

    /**
     * Get last transaction instance
     *
     * @return TransactionInterface
     */
    public function getTransaction()
    {
        return $this->last();
    }

    /**
     * Listen to query events
     *
     * @param callable $callback
     * @return ConnectionInterface
     */
    public function listen(callable $callback)
    {
        $this->getEvent()
            ->listen($callback);

        return $this;
    }

    /**
     * Pop transaction instance
     *
     * @return null|TransactionInterface
     */
    public function popTransaction()
    {
        return $this->pop();
    }

    /**
     * Push transaction instance
     *
     * @param TransactionInterface $transaction
     * @return ConnectionInterface
     */
    public function pushTransaction(TransactionInterface $transaction)
    {
        $this->push($transaction);

        return $this;
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        $this->popTransaction()
            ->rollback();
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
        // Create statement
        $statement = $this->getFactory()
            ->createStatement($query, $parameters);

        // Run statement through the server
        $this->createRequest()
            ->pushStatement($statement)
            ->execute();

        // Return statement result
        return $statement->getResult();
    }
}
