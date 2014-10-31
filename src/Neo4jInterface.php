<?php
/**
 * Neo4j interface file
 *
 * @package EndyJasmi;
 */
namespace EndyJasmi;

use EndyJasmi\Neo4j\ConnectionInterface;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use InvalidArgumentException;

/**
 * Neo4jInterface is an interface for neo4j class
 */
interface Neo4jInterface
{
    /**
     * Neo4j constructor
     *
     * @param string $configPath Configuration path
     * @param ContainerInterface $container Container  instance
     */
    public function __construct($configPath = null, ContainerInterface $container = null);

    /**
     * Dyamically call the default connection instance
     *
     * @param string $method Connection method
     * @param array $parameters Connection method parameters
     *
     * @return mixed Return method result
     */
    public function __call($method, $parameters);

    /**
     * Get a connection instance
     *
     * @param string $profile Profile name
     *
     * @return ConnectionInterface Return connection
     *
     * @throws InvalidArgumentException If profile not found
     */
    public function connection($profile = null);

    /**
     * Get the default profile name
     *
     * @return string Return profile name
     */
    public function getDefaultProfile();
}
