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
     * @param boolean $throws
     */
    public function __construct(
        FactoryInterface $factory,
        ConnectionInterface $connection,
        RequestInterface $request,
        array $response,
        $throws = true
    ) {
        $this->setFactory($factory)
            ->setConnection($connection)
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
            ->createRequest();
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
