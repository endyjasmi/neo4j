<?php
/**
 * Result class file
 *
 * @package EndyJasmi\Neo4j\Response;
 */
namespace EndyJasmi\Neo4j\Response;

use EndyJasmi\Neo4j\ConnectionInterface;
use EndyJasmi\Neo4j\Request\StatementInterface;
use Illuminate\Support\Collection;

/**
 * Result is a concrete implementation of result interface
 */
class Result extends Collection implements ResultInterface
{
    /**
     * @var ConnectionInterface Connection instance
     */
    protected $connection;

    /**
     * @var StatementInterface Statement instance
     */
    protected $statement;

    /**
     * @var array Status array
     */
    protected $status;

    /**
     * Result constructor
     *
     * @param ConnectionInterface $connection Connection instance
     * @param StatementInterface $statement Statement instance
     * @param array $result Raw result
     */
    public function __construct(ConnectionInterface $connection, StatementInterface $statement, array $result)
    {
        $this->setConnection($connection)
            ->setStatement($statement);

        foreach ($result['data'] as $data) {
            $this->push(array_combine($result['columns'], $data['row']));
        }

        $this->status = $result['stats'];
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
     * Get statement instance
     *
     * @return StatementInterface Return statement instance
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Get status instance
     *
     * @return StatusInterface Return status instance
     */
    public function getStatus()
    {
        return $this->getConnection()
            ->createStatus($this, $this->status);
    }

    /**
     * Set connection instance
     *
     * @param ConnectionInterface $connection Connection instance
     *
     * @return ResultInterface Return self
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Set statement instance
     *
     * @param StatementInterface $statement Statement instance
     *
     * @return ResultInterface Return self
     */
    public function setStatement(StatementInterface $statement)
    {
        $this->statement = $statement->setResult($this);

        $this->getConnection()
            ->fire($statement->getQuery(), $statement->getParameters(), $statement->getTime());

        return $this;
    }
}
