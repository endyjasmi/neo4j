<?php namespace EndyJasmi;

use EndyJasmi\Neo4j\Connection;

class Neo4j
{
    protected static $config = array(
        'default' => array(
            'host' => 'http://localhost:7474',
            'driver' => Connection::CURL
        )
    );

    protected $configs = array();

    protected $connections = array();

    public function __construct(array $config = array())
    {
        $this->configs = array_merge(
            self::$config,
            $config
        );
    }

    public function __call($method, $arguments)
    {
        $connection = $this->connection('default');

        return call_user_func_array(
            array($connection, $method),
            $arguments
        );
    }

    public function connection($connection)
    {
        if (!array_key_exists($connection, $this->configs)) {
            throw new Exception('No connection found');
        }

        if (!array_key_exists($connection, $this->connections)) {
            if (!isset($this->configs[$connection]['driver'])) {
                $this->configs[$connection]['driver'] = Connection::CURL;
            }

            $this->connections[$connection] = new Connection(
                $this->configs[$connection]['host'],
                $this->configs[$connection]['driver']
            );
        }

        return $this->connections[$connection];
    }
}
