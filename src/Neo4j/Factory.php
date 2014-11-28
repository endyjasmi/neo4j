<?php namespace EndyJasmi\Neo4j;

use Illuminate\Container\Container;
use InvalidArgumentException;

class Factory implements FactoryInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Bind interfaces
     *
     * @param Container $container
     */
    protected function bindInterfaces(Container $container)
    {
        $container->bind('EndyJasmi\Neo4j\ConnectionInterface', 'EndyJasmi\Neo4j\Connection');
        $container->bind('EndyJasmi\Neo4j\ErrorInterface', 'EndyJasmi\Neo4j\Error');
        $container->bind('EndyJasmi\Neo4j\RequestInterface', 'EndyJasmi\Neo4j\Request');
        $container->bind('EndyJasmi\Neo4j\ResponseInterface', 'EndyJasmi\Neo4j\Response');
        $container->bind('EndyJasmi\Neo4j\ResultInterface', 'EndyJasmi\Neo4j\Result');
        $container->bind('EndyJasmi\Neo4j\StatementInterface', 'EndyJasmi\Neo4j\Statement');
        $container->bind('EndyJasmi\Neo4j\StatusInterface', 'EndyJasmi\Neo4j\Status');
    }

    /**
     * Factory constructor
     *
     * @param Container $container
     */
    public function __construct(Container $container = null)
    {
        $container = $container ?: new Container;

        $this->setContainer($container)
            ->bindInterfaces($container);
    }

    /**
     * Create connection instance
     *
     * @param DriverInterface $driver
     * @return ConnectionInterface
     */
    public function createConnection(DriverInterface $driver)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\ConnectionInterface',
                [
                    'factory' => $this,
                    'driver' => $driver
                ]
            );
    }

    /**
     * Create error instance
     *
     * @param array $errors
     * @param boolean $throws
     * @return ErrorInterface
     */
    public function createError(array $errors, $throws = true)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\ErrorInterface',
                [
                    'factory' => $this,
                    'errors' => $errors,
                    'throws' => $throws
                ]
            );
    }

    /**
     * Create exception instance
     *
     * @param array $error
     * @return Neo
     */
    public function createException(array $error)
    {
        $code = $error['code'];
        $message = $error['message'];
        $namespace = ['EndyJasmi', 'Neo4j', 'Error'];

        $class = array_merge($namespace, explode('.', $code));
        $class = implode('\\', $class);

        return new $class($message);
    }

    /**
     * Create request instance
     *
     * @param ConnectionInterface $connection
     * @param null|integer $id
     * @return RequestInterface
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function createRequest(ConnectionInterface $connection, $id = null)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\RequestInterface',
                [
                    'factory' => $this,
                    'connection' => $connection,
                    'id' => $id
                ]
            );
    }

    /**
     * Create response instance
     *
     * @param ConnectionInterface $connection
     * @param RequestInterface $request
     * @param array $response
     * @param null|integer $id
     * @param boolean $throws
     * @return ResponseInterface
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function createResponse(
        ConnectionInterface $connection,
        RequestInterface $request,
        array $response,
        $id = null,
        $throws = true
    ) {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\ResponseInterface',
                [
                    'factory' => $this,
                    'connection' => $connection,
                    'request' => $request,
                    'response' => $response,
                    'id' => $id,
                    'throws' => $throws
                ]
            );
    }

    /**
     * Create result instance
     *
     * @param StatementInterface $statement
     * @param array $result
     */
    public function createResult(StatementInterface $statement, array $result)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\ResultInterface',
                [
                    'factory' => $this,
                    'statement' => $statement,
                    'result' => $result
                ]
            );
    }

    /**
     * Create statement instance
     *
     * @param string $query
     * @param array $parameters
     * @return StatementInterface
     * @throws InvalidArgumentException If $query is not string
     */
    public function createStatement($query, array $parameters = [])
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\StatementInterface',
                [
                    'query' => $query,
                    'parameters' => $parameters
                ]
            );
    }

    /**
     * Create status instance
     *
     * @param array $status
     * @return StatusInterface
     */
    public function createStatus(array $status)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\StatusInterface',
                [
                    'status' => $status
                ]
            );
    }

    /**
     * Get container instance
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set container instance
     *
     * @param Container $container
     * @return FactoryInterface
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }
}
