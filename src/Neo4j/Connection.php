<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\DriverManagerTrait;
use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;
use InvalidArgumentException;

class Connection extends Collection implements ConnectionInterface
{
    use DriverManagerTrait;
    use FactoryManagerTrait;

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
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function beginTransaction(RequestInterface $request = null)
    {
        $driver = $this->getDriver();
        $request = $request ?: $this->createRequest();

        $transaction = $this->getFactory()
            ->createTransaction($driver, $request);

        $this->pushTransaction($transaction);

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
        $request = $request ?: $this->createRequest();

        return $this->popTransaction()
            ->commit($request);
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
        return $this->getTransaction()
            ->execute($request);
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
        $statement = $this->getFactory()
            ->createStatement($query, $parameters);

        $this->createRequest()
            ->pushStatement($statement)
            ->execute();

        return $statement->getResult();
    }
}
