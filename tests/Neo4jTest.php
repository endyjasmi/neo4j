<?php namespace EndyJasmi;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class Neo4jTest extends TestCase
{
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

    public function setUp()
    {
        $this->factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');
    }

    public function testConnectionMethod()
    {
        // Given
        $neo4j = new Neo4j($this->options, $this->factory);

        $connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');
        $this->factory->shouldReceive('createConnection')
            ->once()
            ->andReturn($connection);

        // When
        $connection = $neo4j->connection();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ConnectionInterface', $connection);
    }

    public function testGetDefaultConnectionMethod()
    {
        // Given
        $neo4j = new Neo4j($this->options, $this->factory);

        // When
        $connection = $neo4j->getDefaultConnection();

        // Expect
        $this->assertInternalType('string', $connection);
    }

    public function testGetDefaultDriverMethod()
    {
        // Given
        $neo4j = new Neo4j;

        // When
        $driver = $neo4j->getDefaultDriver();

        // Expect
        $this->assertInternalType('string', $driver);
    }

    public function testGetOptionsMethod()
    {
        // Given
        $neo4j = new Neo4j;

        // When
        $options = $neo4j->getOptions();

        // Expect
        $this->assertInternalType('array', $options);
    }

    public function testSetOptionsMethod()
    {
        // Given
        $neo4j = new Neo4j;

        // When
        $self = $neo4j->setOptions($this->options);

        // Expect
        $this->assertSame($neo4j, $self);
    }
}
