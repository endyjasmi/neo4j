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
     * Bind event component
     *
     * @param Containter Container
     * @return Factory
     */
    protected function bindEvent(Container $container)
    {
        $container->bindShared(
            'events',
            function (Container $container) {
                return $container->make(
                    'Illuminate\Events\Dispatcher',
                    [
                        'container' => $container
                    ]
                );
            }
        );

        return $this;
    }

    /**
     * Bind interfaces
     *
     * @param Container $container
     * @return Factory
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
        $container->bind('EndyJasmi\Neo4j\TransactionInterface', 'EndyJasmi\Neo4j\Transaction');

        return $this;
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
            ->bindInterfaces($container)
            ->bindEvent($container);
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
     * @return RequestInterface
     */
    public function createRequest(ConnectionInterface $connection)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\RequestInterface',
                [
                    'factory' => $this,
                    'connection' => $connection,
                ]
            );
    }

    /**
     * Create response instance
     *
     * @param RequestInterface $request
     * @param array $response
     * @param boolean $throws
     * @return ResponseInterface
     */
    public function createResponse(
        RequestInterface $request,
        array $response,
        $throws = true
    ) {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\ResponseInterface',
                [
                    'factory' => $this,
                    'request' => $request,
                    'response' => $response,
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
     * Create transaction instance
     *
     * @param DriverInterface $driver
     * @param RequestInterface $request
     */
    public function createTransaction(DriverInterface $driver, RequestInterface $request)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\TransactionInterface',
                [
                    'factory' => $this,
                    'driver' => $driver,
                    'request' => $request
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
     * Determine if component exists
     *
     * @param string $key
     * @return boolean
     */
    public function offsetExists($key)
    {
        $container = $this->getContainer();

        return isset($container[$key]);
    }

    /**
     * Get the component
     *
     * @param string $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        $container = $this->getContainer();

        return $container[$key];
    }

    /**
     * Set the component
     *
     * @param string $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        $container = $this->getContainer();
        $container[$key] = $value;
    }

    /**
     * Unset the component
     *
     * @param string $key
     */
    public function offsetUnset($key)
    {
        $container = $this->getContainer();

        unset($container[$key]);
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
