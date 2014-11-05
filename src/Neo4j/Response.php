<?php
/**
 * Response class file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use DomainException;
use EndyJasmi\Neo4j\Response\ErrorsInterface;
use Illuminate\Support\Collection;

/**
 * Response is a concrete implementation of response interface
 */
class Response extends Collection implements ResponseInterface
{
    /**
     * @var ConnectionInterface Connection instance
     */
    protected $connection;

    /**
     * @var ErrorsInterface Errors instance
     */
    protected $errors;

    /**
     * @var integer Transaction id
     */
    protected $id;

    /**
     * @var RequestInterface Request instance
     */
    protected $request;

    /**
     * Redirect to query builder
     *
     * @param string $method Method name
     * @param array $parameters Parameter array
     *
     * @return mixed Return query result
     */
    public function __call($method, array $parameters = [])
    {
        return call_user_func_array([$this->getConnection()->createBuilder($this), $method], $parameters);
    }

    /**
     * Response constructor
     *
     * @param ConnectionInterface $connection Connection instance
     * @param RequestInterface $request Request instance
     * @param array $response Response array
     * @param boolean $throws Auto throws exception
     */
    public function __construct(
        ConnectionInterface $connection,
        RequestInterface $request,
        array $response,
        $throws = true
    ) {
        $this->setConnection($connection)
            ->setRequest($request);

        $this->errors = $this->getConnection()
            ->createErrors($response['errors'], $throws);

        foreach ($response['results'] as $index => $result) {
            $result = $this->getConnection()
                ->createResult($request[$index], $result);

            $this->push($result);
        }

        if (array_key_exists('id', $response)) {
            $this->setId($response['id']);
        }
    }

    /**
     * Commit an open transaction
     *
     * @return ResponseInterface Return response instance
     *
     * @throws DomainException If transaction id not set
     */
    public function commit()
    {
        if (is_null($this->getId())) {
            throw new DomainException('This is not a transaction.');
        }

        $request = $this->getConnection()
            ->createRequest($this->getId());

        return $this->getConnection()
            ->commit($request);
    }

    /**
     * Create request instance
     *
     * @return RequestInstance Return request instance
     */
    public function createRequest()
    {
        return $this->getConnection()
            ->createRequest($this->getId());
    }

    /**
     * Get connection instance
     *
     * @return ConnectionInterface Return connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Get errors instance
     *
     * @return ErrorsInterface Return errors instance
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get transaction id
     *
     * @return null|integer Return null or transaction id if set
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get request instance
     *
     * @return RequestInterface Return request instance
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Rollback an open transaction
     *
     * @return ResponseInterface Return response instance
     *
     * @throws DomainException If transaction id not set
     */
    public function rollback()
    {
        if (is_null($this->getId())) {
            throw new DomainException('This is not a transaction.');
        }
        
        $request = $this->getConnection()
            ->createRequest($this->getId());

        return $this->getConnection()
            ->rollback($request);
    }

    /**
     * Set connection instance
     *
     * @param ConnectionInterface $connection Connection instance
     *
     * @return ResponseInterface Return self
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Set transaction id
     *
     * @param integer $id Transaction id
     *
     * @return ResponseInterface Return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set request instance
     *
     * @param RequestInterface $request Request instance
     *
     * @return ResponseInterface Return self
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request->setResponse($this);

        return $this;
    }

    /**
     * Run a single statement
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     *
     * @return ResultInterface Return result instance
     */
    public function statement($query, array $parameters = [])
    {
        $statement = $this->getConnection()
            ->createStatement($query, $parameters);

        $this->createRequest()
            ->pushStatement($statement)
            ->execute();

        return $statement->getResult();
    }
}
