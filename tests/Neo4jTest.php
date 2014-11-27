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
