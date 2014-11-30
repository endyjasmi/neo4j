<?php namespace EndyJasmi\Neo4j;

use ArrayAccess;
use EndyJasmi\Neo4j\Error\Neo;
use EndyJasmi\Neo4j\Manager\EventManagerInterface;
use Illuminate\Container\Container;
use InvalidArgumentException;

interface FactoryInterface extends ArrayAccess, EventManagerInterface
{
    /**
     * Factory constructor
     *
     * @param Container $container
     */
    public function __construct(Container $container = null);

    /**
     * Create connection instance
     *
     * @param DriverInterface $driver
     * @return ConnectionInterface
     */
    public function createConnection(DriverInterface $driver);

    /**
     * Create error instance
     *
     * @param array $errors
     * @param boolean $throws
     * @return ErrorInterface
     */
    public function createError(array $errors, $throws = true);

    /**
     * Create event instance
     *
     * @return EventInterface
     */
    public function createEvent();

    /**
     * Create exception instance
     *
     * @param array $error
     * @return Neo
     */
    public function createException(array $error);

    /**
     * Create request instance
     *
     * @param ConnectionInterface $connection
     * @return RequestInterface
     */
    public function createRequest(ConnectionInterface $connection);

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
    );

    /**
     * Create result instance
     *
     * @param StatementInterface $statement
     * @param array $result
     */
    public function createResult(StatementInterface $statement, array $result);

    /**
     * Create statement instance
     *
     * @param string $query
     * @param array $parameters
     * @return StatementInterface
     * @throws InvalidArgumentException If $query is not string
     */
    public function createStatement($query, array $parameters = []);

    /**
     * Create status instance
     *
     * @param array $status
     * @return StatusInterface
     */
    public function createStatus(array $status);

    /**
     * Create timer instance
     *
     * @return TimerInterface
     */
    public function createTimer();

    /**
     * Create transaction instance
     *
     * @param DriverInterface $driver
     * @param RequestInterface $request
     */
    public function createTransaction(DriverInterface $driver, RequestInterface $request);

    /**
     * Get container instance
     *
     * @return Container
     */
    public function getContainer();

    /**
     * Set container instance
     *
     * @param Container $container
     * @return FactoryInterface
     */
    public function setContainer(Container $container);
}
