<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Error\Neo;
use Illuminate\Container\Container;
use InvalidArgumentException;

interface FactoryInterface
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
     * @param null|integer $id
     * @return RequestInterface
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function createRequest(ConnectionInterface $connection, $id = null);

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
