<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\ConnectionInterface;

trait ConnectionManagerTrait
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Get connection instance
     *
     * @return ConenctionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Set connection instance
     *
     * @param ConnectionInterface $connection
     * @return ConnectionManagerTrait
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;

        return $this;
    }
}
