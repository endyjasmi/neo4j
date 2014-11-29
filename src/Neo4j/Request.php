<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\ConnectionManagerTrait;
use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;
use InvalidArgumentException;

class Request extends Collection implements RequestInterface
{
    use ConnectionManagerTrait;
    use FactoryManagerTrait;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Request constructor
     *
     * @param FactoryInterface $factory
     * @param ConnectionInterface $connection
     * @param TransactionInterface $transaction
     */
    public function __construct(FactoryInterface $factory, ConnectionInterface $connection)
    {
        $this->setFactory($factory)
            ->setConnection($connection);
    }

    /**
     * Begin transaction
     *
     * @return ResponseInterface
     */
    public function beginTransaction()
    {
        return $this->getConnection()
            ->beginTransaction($this);
    }

    /**
     * Commit transaction
     *
     * @return ResponseInterface
     */
    public function commit()
    {
        return $this->getConnection()
            ->commit($this);
    }

    /**
     * Execute transaction
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        return $this->getConnection()
            ->execute($this);
    }

    /**
     * Get response instace
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Pop statement instance
     *
     * @return StatementInterface
     */
    public function popStatement()
    {
        return $this->pop();
    }

    /**
     * Push statement instance
     *
     * @param StatementInterface
     * @return RequestInterface
     */
    public function pushStatement(StatementInterface $statement)
    {
        $this->push($statement);

        return $this;
    }

    /**
     * Set response instance
     *
     * @param ResponseInterface
     * @return RequestInterface
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Create and push statement into request
     *
     * @param string $query
     * @param array $parameters
     * @return RequestInterface
     * @throws InvalidArgumentException If $query is not string
     */
    public function statement($query, array $parameters = [])
    {
        $statement = $this->getFactory()
            ->createStatement($query, $parameters);

        return $this->pushStatement($statement);
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'statements' => parent::toArray()
        ];
    }
}
