<?php
/**
 * Connection interface file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Request\StatementInterface;
use EndyJasmi\Neo4j\Response\ErrorsInterface;
use EndyJasmi\Neo4j\Response\ResultInterface;
use EndyJasmi\Neo4j\Response\StatusInterface;
use Illuminate\Contracts\Container\Container as ContainerInterface;

/**
 * ConnectionInterface is an interface for connection class
 */
interface ConnectionInterface
{
    /**
     * Connection constructor
     *
     * @param ContainerInterface $container Container instance
     * @param DriverInterface $driver Driver instance
     */
    public function __construct(ContainerInterface $container, DriverInterface $driver);

    /**
     * Begin a new transaction
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return response instance
     */
    public function beginTransaction(RequestInterface $request = null);

    /**
     * Commit a transaction
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return response instance
     */
    public function commit(RequestInterface $request);

    /**
     * Create response errors
     *
     * @param array $errors Errors array
     * @param boolean $throws Auto throws exception
     *
     * @return ErrorsInterface Return errors instance
     */
    public function createErrors(array $errors, $throws = true);

    /**
     * Create request instance
     *
     * @param integer $id Transaction id
     *
     * @return RequestInterface Return request instance
     */
    public function createRequest($id = null);

    /**
     * Create response instance
     *
     * @param RequestInterface $request Request instance
     * @param array $response Response array
     * @param boolean $throws Auth throws exception
     *
     * @return ResponseInterface Return response instance
     */
    public function createResponse(RequestInterface $request, array $response, $throws = true);

    /**
     * Create result instance
     *
     * @param StatementInterface $statement Statement instance
     * @param array $result Result array
     *
     * @return ResultInterface Return result instance
     */
    public function createResult(StatementInterface $statement, array $result);

    /**
     * Create statement instance
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     *
     * @return StatementInterface Return statement instance
     */
    public function createStatement($query, array $parameters = []);

    /**
     * Create status instance
     *
     * @param ResultInterface $result Result instance
     * @param array $status Status array
     *
     * @return StatusInterface Return status instance
     */
    public function createStatus(ResultInterface $result, array $status);

    /**
     * Fire query event
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     * @param float $time Runnin time
     */
    public function fire($query, $parameters, $time);

    /**
     * Get container instance
     *
     * @return ContainerInterface Return container instance
     */
    public function getContainer();

    /**
     * Get driver instance
     *
     * @return DriverInterface Return driver instance
     */
    public function getDriver();

    /**
     * Execute an open transaction
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return response instance
     */
    public function execute(RequestInterface $request);

    /**
     * Listen to query event
     *
     * @param callable $listener Callable listener
     */
    public function listen(callable $listener);

    /**
     * Rollback an open transaction
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return response instance
     */
    public function rollback(RequestInterface $request);

    /**
     * Set container instance
     *
     * @param ContainerInterface $container Container instance
     *
     * @return ConnectionInterface Return self
     */
    public function setContainer(ContainerInterface $container);

    /**
     * Set driver instance
     *
     * @param DriverInterface $driver Driver instance
     *
     * @return ConnectionInterface Return self
     */
    public function setDriver(DriverInterface $driver);

    /**
     * Run a general statement
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     *
     * @return ResultInterface Return result instance
     */
    public function statement($query, array $parameters = []);

    /**
     * Run a set of operation in database transaction
     *
     * @param callable $callable Database operations
     */
    public function transaction(callable $callable);
}
