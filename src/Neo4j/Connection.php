<?php
/**
 * Connection class file
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
 * Connection is a concrete implementation of connection interface
 */
class Connection implements ConnectionInterface
{
    /**
     * @var ContainerInterface Container instance
     */
    protected $container;

    /**
     * @var DriverInterface Driver instance
     */
    protected $driver;

    /**
     * Connection constructor
     *
     * @param ContainerInterface $container Container instance
     * @param DriverInterface $driver Driver instance
     */
    public function __construct(ContainerInterface $container, DriverInterface $driver)
    {
        $this->setContainer($container)
            ->setDriver($driver);
    }
    
    /**
     * Begin a new transaction
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return response instance
     */
    public function beginTransaction(RequestInterface $request = null)
    {
        if (is_null($request)) {
            $request = $this->createRequest();
        }

        $response = $this->getDriver()
            ->beginTransaction($request->toArray());

        return $this->createResponse($request, $response);
    }

    /**
     * Commit a transaction
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return response instance
     */
    public function commit(RequestInterface $request)
    {
        $response = $this->getDriver()
            ->commitTransaction($request->toArray());

        return $this->createResponse($request, $response);
    }

    /**
     * Create response errors
     *
     * @param array $errors Errors array
     * @param boolean $throws Auto throws exception
     *
     * @return ErrorsInterface Return errors instance
     */
    public function createErrors(array $errors, $throws = true)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\Response\ErrorsInterface',
                [
                    'errors' => $errors,
                    'throws' => $throws
                ]
            );
    }

    /**
     * Create request instance
     *
     * @param integer $id Transaction id
     *
     * @return RequestInterface Return request instance
     */
    public function createRequest($id = null)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\RequestInterface',
                [
                    'connection' => $this,
                    'id' => $id
                ]
            );
    }

    /**
     * Create response instance
     *
     * @param RequestInterface $request Request instance
     * @param array $response Response array
     * @param boolean $throws Auth throws exception
     *
     * @return ResponseInterface Return response instance
     */
    public function createResponse(RequestInterface $request, array $response, $throws = true)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\ResponseInterface',
                [
                    'connection' => $this,
                    'request' => $request,
                    'response' => $response,
                    'throws' => $throws
                ]
            );
    }

    /**
     * Create result instance
     *
     * @param StatementInterface $statement Statement instance
     * @param array $result Result array
     *
     * @return ResultInterface Return result instance
     */
    public function createResult(StatementInterface $statement, array $result)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\Response\ResultInterface',
                [
                    'connection' => $this,
                    'statement' => $statement,
                    'result' => $result
                ]
            );
    }

    /**
     * Create statement instance
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     *
     * @return StatementInterface Return statement instance
     */
    public function createStatement($query, array $parameters = [])
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\Request\StatementInterface',
                [
                    'query' => $query,
                    'parameters' => $parameters
                ]
            );
    }

    /**
     * Create status instance
     *
     * @param ResultInterface $result Result instance
     * @param array $status Status array
     *
     * @return StatusInterface Return status instance
     */
    public function createStatus(ResultInterface $result, array $status)
    {
        return $this->getContainer()
            ->make(
                'EndyJasmi\Neo4j\Response\StatusInterface',
                [
                    'result' => $result,
                    'status' => $status
                ]
            );
    }

    /**
     * Fire query event
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     * @param float $time Runnin time
     */
    public function fire($query, $parameters, $time)
    {
        $container = $this->getContainer();

        $container['events']->fire('neo4j.query', [$query, $parameters, $time]);
    }

    /**
     * Get container instance
     *
     * @return ContainerInterface Return container instance
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get driver instance
     *
     * @return DriverInterface Return driver instance
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Execute an open transaction
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return response instance
     */
    public function execute(RequestInterface $request)
    {
        $response = $this->getDriver()
            ->executeTransaction($request->toArray());

        return $this->createResponse($request, $response);
    }

    /**
     * Listen to query event
     *
     * @param callable $listener Callable listener
     */
    public function listen(callable $listener)
    {
        $container = $this->getContainer();

        $container['events']->listen('neo4j.query', $listener);
    }

    /**
     * Rollback an open transaction
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return response instance
     */
    public function rollback(RequestInterface $request)
    {
        $response = $this->getDriver()
            ->rollbackTransaction($request->toArray());

        return $this->createResponse($request, $response);
    }

    /**
     * Set container instance
     *
     * @param ContainerInterface $container Container instance
     *
     * @return ConnectionInterface Return self
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Set driver instance
     *
     * @param DriverInterface $driver Driver instance
     *
     * @return ConnectionInterface Return self
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Run a general statement
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     *
     * @return ResultInterface Return result instance
     */
    public function statement($query, array $parameters = [])
    {
        $statement = $this->createStatement($query, $parameters);

        $this->createRequest()
            ->pushStatement($statement)
            ->commit();

        return $statement->getResult();
    }

    /**
     * Run a set of operation in database transaction
     *
     * @param callable $callable Database operations
     */
    public function transaction(callable $callable)
    {
        $transaction = $this->beginTransaction();

        $callable($transaction);

        $transaction->commit();
    }
}
