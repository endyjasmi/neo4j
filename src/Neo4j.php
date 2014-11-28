<?php namespace EndyJasmi;

use EndyJasmi\Neo4j\Driver\CurlDriver;
use EndyJasmi\Neo4j\Driver\StreamDriver;
use EndyJasmi\Neo4j\Factory;
use EndyJasmi\Neo4j\FactoryInterface;
use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;
use Illuminate\Support\Manager;

class Neo4j extends Manager implements Neo4jInterface
{
    use FactoryManagerTrait;

    /**
     * @var array
     */
    protected $connections = [];

    /**
     * @var array
     */
    protected $options = [
        'default' => 'default',
        'driver' => 'auto',
        'connections' => [
            'default' => [
                'scheme' => 'http',
                'host' => 'localhost',
                'port' => 7474,
                'username' => '',
                'password' => ''
            ]
        ]
    ];

    /**
     * Create curl driver
     *
     * @return CurlDriver
     */
    protected function createCurlDriver()
    {
        return new CurlDriver;
    }

    /**
     * Create stream driver
     *
     * @return StreamDriver
     */
    protected function createStreamDriver()
    {
        return new StreamDriver;
    }

    /**
     * Dynamically call the default connection instance
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->connection(), $method], $parameters);
    }

    /**
     * Neo4j constructor
     *
     * @param array $options
     * @param FactoryInterface $factory
     */
    public function __construct(array $options = [], FactoryInterface $factory = null)
    {
        $factory = $factory ?: new Factory;

        $this->setOptions($options)
            ->setFactory($factory);
    }

    /**
     * Get a connection instance
     *
     * @param string $connection
     * @return ConnectionInterface
     */
    public function connection($connection = null)
    {
        $connection = $connection ?: $this->getDefaultConnection();

        if (! isset($this->connections[$connection])) {
            $options = $this->getOptions();
            $options = $options['connections'][$connection];

            $driver = $this->getDefaultDriver();
            $driver = $this->createDriver($driver);
            $driver->setOptions($options);


            $this->connections[$connection] = $this->getFactory()
                ->createConnection($driver);
        }

        return $this->connections[$connection];
    }

    /**
     * Get default connection
     *
     * @return string
     */
    public function getDefaultConnection()
    {
        $options = $this->getOptions();

        return $options['default'];
    }

    /**
     * Get default driver
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        $driver = $this->options['driver'];

        if ($driver == 'auto') {
            $driver = 'stream';

            if (function_exists('curl_init')) {
                $driver = 'curl';
            }
        }

        return $driver;
    }

    /**
     * Get neo4j options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set neo4j options
     *
     * @param array $options
     * @return Neo4jInterface
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }
}
