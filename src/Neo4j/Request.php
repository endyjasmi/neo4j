<?php
/**
 * Request class file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Request\StatementInterface;
use Illuminate\Support\Collection;

/**
 * Request is a concrete implementation of request interface
 */
class Request extends Collection implements RequestInterface
{
    /**
     * @var ConnectionInterface Connection instance
     */
    protected $connection;

    /**
     * @var integer Transaction id
     */
    protected $id;

    /**
     * @var ResponseInterface Response instance
     */
    protected $response;

    /**
     * Request constructor
     *
     * @param ConnectionInterface $connection Connection instance
     * @param integer $id Transaction id
     */
    public function __construct(ConnectionInterface $connection, $id = null)
    {
        $this->setConnection($connection)
            ->setId($id);
    }

    /**
     * Begin a new transaction
     *
     * @return ResponseInterface Return transaction response
     */
    public function beginTransaction()
    {
        return $this->getConnection()
            ->beginTransaction($this);
    }

    /**
     * Commit a transaction
     *
     * @return ResponseInterface Return transaction response
     */
    public function commit()
    {
        return $this->getConnection()
            ->commit($this);
    }

    /**
     * Execute an open transaction
     *
     * @return ResponseInterface Return transaction response
     */
    public function execute()
    {
        return $this->getConnection()
            ->execute($this);
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
     * Get transaction id
     *
     * @return null|integer Return null or transaction id if set
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get response instance
     *
     * @return null|ResponseInterface Return null or response instance if set
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Pop statement instance from collection
     *
     * @return StatementInterface Return statement instance
     */
    public function popStatement()
    {
        return $this->pop();
    }

    /**
     * Push statement instance into the collection
     *
     * @param StatementInterface $statement Statement instance
     *
     * @return RequestInterface Return self
     */
    public function pushStatement(StatementInterface $statement)
    {
        $this->push($statement);

        return $this;
    }

    /**
     * Set connection instance
     *
     * @param ConnectionInterface $connection Connection instance
     *
     * @return RequestInterface Return self
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
     * @return RequestInterface Return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set response instance
     *
     * @param ResponseInterface $response Response instance
     *
     * @return RequestInterface Return self
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Create and push statement into the stack
     *
     * @param string $query Query string
     * @param array $parameters Parameters array
     *
     * @return RequestInterface Return self
     */
    public function statement($query, array $parameters = [])
    {
        $statement = $this->getConnection()
            ->createStatement($query, $parameters);

        return $this->pushStatement($statement);
    }

    /**
     * Convert request to array
     */
    public function toArray()
    {
        $request = [
            'statements' => parent::toArray()
        ];

        $id = $this->getId();

        if (! is_null($id)) {
            $request['id'] = $id;
        }

        return $request;
    }
}
