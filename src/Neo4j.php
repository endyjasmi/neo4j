<?php
/**
 * Neo4j class file
 *
 * @package EndyJasmi;
 */
namespace EndyJasmi;

use EndyJasmi\Neo4j\Container;
use EndyJasmi\Neo4j\ConnectionInterface;
use EndyJasmi\Neo4j\Driver\CurlDriver;
use EndyJasmi\Neo4j\Driver\StreamDriver;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Support\Manager;
use InvalidArgumentException;

/**
 * Neo4j is a concrete implementation of neo4j interface
 */
class Neo4j extends Manager implements Neo4jInterface
{
    /**
     * @var array Connection caches
     */
    protected $connections = [];

    /**
     * @var string Default profile name
     */
    protected $default;

    /**
     * @var array Profile options
     */
    protected $profiles = [];

    /**
     * Neo4j constructor
     *
     * @param string $configPath Configuration path
     * @param ContainerInterface $container Container  instance
     */
    public function __construct($configPath = null, ContainerInterface $container = null)
    {
        if (is_null($container)) {
            $container = new Container($configPath);
        }

        parent::__construct($container);

        $this->default = $this->app['config']->get('database.neo4j.default');
        $this->profiles = $this->app['config']->get('database.neo4j.profiles');
        $this->events = $this->app['events'];
    }

    /**
     * Dyamically call the default connection instance
     *
     * @param string $method Connection method
     * @param array $parameters Connection method parameters
     *
     * @return mixed Return method result
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->connection(), $method], $parameters);
    }

    /**
     * Get a connection instance
     *
     * @param string $profile Profile name
     *
     * @return ConnectionInterface Return connection
     *
     * @throws InvalidArgumentException If profile not found
     */
    public function connection($profile = null)
    {
        $profile = $profile ?: $this->getDefaultProfile();

        if (! array_key_exists($profile, $this->profiles)) {
            throw new InvalidArgumentException("Profile [$profile] not found.");
        }

        if (! array_key_exists($profile, $this->connections)) {
            $driver = $this->driver()
                ->setOptions($this->profiles[$profile]);

            $this->connections[$profile] = $this->app->make(
                'EndyJasmi\Neo4j\ConnectionInterface',
                [
                    'container' => $this->app,
                    'driver' => $driver
                ]
            );
        }

        return $this->connections[$profile];
    }

    /**
     * Create curl driver instance
     *
     * @return DriverInterface Return driver instance
     */
    public function createCurlDriver()
    {
        return new CurlDriver;
    }

    /**
     * Create stream driver instance
     *
     * @return DriverInterface Return driver instance
     */
    public function createStreamDriver()
    {
        return new StreamDriver;
    }

    /**
     * Get default driver name
     *
     * @return string Return driver name string
     */
    public function getDefaultDriver()
    {
        $driver = 'stream';

        if (function_exists('curl_init')) {
            $driver = 'curl';
        }

        return $driver;
    }

    /**
     * Get the default profile name
     *
     * @return string Return profile name
     */
    public function getDefaultProfile()
    {
        return $this->default;
    }
}
