<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\ConnectionManagerTrait;
use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;
use InvalidArgumentException;

class Response extends Collection implements ResponseInterface
{
    use ConnectionManagerTrait;
    use FactoryManagerTrait;
    /**
     * @var ErrorInterface
     */
    protected $error;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var RequestInterface
     */
    protected $request;

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
    ) {
        $this->setFactory($factory)
            ->setConnection($connection)
            ->setRequest($request)
            ->setId($id);

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
     * Commit transaction
     *
     * @return ResponseInterface
     */
    public function commit()
    {
        return $this->createRequest()
            ->commit();
    }

    /**
     * Create request instance
     *
     * @return RequestInterface
     */
    public function createRequest()
    {
        return $this->getConnection()
            ->createRequest($this->getId());
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
     * Get response id
     *
     * @return null|integer
     */
    public function getId()
    {
        return $this->id;
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
     * Rollback transaction
     *
     * @return ResponseInterface
     */
    public function rollback()
    {
        $request = $this->createRequest();

        return $this->getConnection()
            ->rollback($request);
    }

    /**
     * Set response id
     *
     * @param null|integer $id
     * @return ResponseInterface
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function setId($id)
    {
        if (! is_null($id) && ! is_integer($id)) {
            throw new InvalidArgumentException('$id is not a null or integer.');
        }

        $this->id = $id;

        return $this;
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
