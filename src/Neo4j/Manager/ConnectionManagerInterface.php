<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\ConnectionInterface;

interface ConnectionManagerInterface
{
    /**
     * Get connection instance
     *
     * @return ConnectionInterface
     */
    public function getConnection();

    /**
     * Set connection instance
     *
     * @param ConnectionInterface
     * @return ConnectionManagerInterface
     */
    public function setConnection(ConnectionInterface $connection);
}
