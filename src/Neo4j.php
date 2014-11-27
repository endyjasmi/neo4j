<?php namespace EndyJasmi;

use EndyJasmi\Neo4j\Driver\CurlDriver;
use EndyJasmi\Neo4j\Driver\StreamDriver;
use Illuminate\Support\Manager;

class Neo4j extends Manager implements Neo4jInterface
{
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
     * Neo4j constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
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
