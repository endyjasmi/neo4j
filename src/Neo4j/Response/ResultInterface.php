<?php
/**
 * Result interface file
 *
 * @package EndyJasmi\Neo4j\Response;
 */
namespace EndyJasmi\Neo4j\Response;

use EndyJasmi\Neo4j\ConnectionInterface;
use EndyJasmi\Neo4j\Request\StatementInterface;

/**
 * ResultInterface is an interface for result class
 */
interface ResultInterface
{
    /**
     * Result constructor
     *
     * @param ConnectionInterface $connection Connection instance
     * @param StatementInterface $statement Statement instance
     * @param array $result Raw result
     */
    public function __construct(ConnectionInterface $connection, StatementInterface $statement, array $result);

    /**
     * Get connection instance
     *
     * @return ConnectionInterface Return connection instance
     */
    public function getConnection();

    /**
     * Get statement instance
     *
     * @return StatementInterface Return statement instance
     */
    public function getStatement();

    /**
     * Get status instance
     *
     * @return StatusInterface Return status instance
     */
    public function getStatus();

    /**
     * Set connection instance
     *
     * @param ConnectionInterface $connection Connection instance
     *
     * @return ResultInterface Return self
     */
    public function setConnection(ConnectionInterface $connection);

    /**
     * Set statement instance
     *
     * @param StatementInterface $statement Statement instance
     *
     * @return ResultInterface Return self
     */
    public function setStatement(StatementInterface $statement);
}
