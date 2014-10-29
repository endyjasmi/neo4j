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
 * @todo Extend collection
 */
interface ResultInterface
{
    /**
     * Result constructor which auto set statement result
     *
     * @param ConnectionInterface $connection Result connection
     * @param StatementInterface $statement Result statement
     * @param array $result Raw result
     */
    public function __construct(ConnectionInterface $connection, StatementInterface $statement, array $result);

    /**
     * Get result connection
     *
     * @return ConnectionInterface Return result connection
     */
    public function getConnection();

    /**
     * Get result statement
     *
     * @return StatementInterface Return result statement
     */
    public function getStatement();

    /**
     * Get result status
     *
     * @return StatusInterface Return result status
     */
    public function getStatus();

    /**
     * Set result connection
     *
     * @param ConnectionInterface $connection Result connection
     *
     * @return ResultInterface Return self
     */
    public function setConnection(ConnectionInterface $connection);

    /**
     * Set result statement
     *
     * @param StatementInterface $statement Result statement
     *
     * @return ResultInterface Return self
     */
    public function setStatement(StatementInterface $statement);
}
