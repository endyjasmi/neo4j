<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\ConnectionManagerTrait;
use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;
use InvalidArgumentException;

class Request extends Collection implements RequestInterface
{
    use ConnectionManagerTrait;
    use FactoryManagerTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Request constructor
     *
     * @param FactoryInterface $factory
     * @param ConnectionInterface $connection
     * @param null|integer $id
     * @throws InvalidArgumentException If $id is not null and integer
     */
    public function __construct(FactoryInterface $factory, ConnectionInterface $connection, $id = null)
    {
        $this->setFactory($factory)
            ->setConnection($connection)
            ->setId($id);
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
     * Get request id
     *
     * @return null|integer
     */
    public function getId()
    {
        return $this->id;
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
     * Set request id
     *
     * @param null|integer $id
     * @return RequestInterface
     * @throws InvalidArgumentException If $id is not null and integer
     */
    public function setId($id)
    {
        if (! is_null($id) && ! is_integer($id)) {
            throw new InvalidArgumentException('$id is not integer.');
        }

        $this->id = $id;

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
}
