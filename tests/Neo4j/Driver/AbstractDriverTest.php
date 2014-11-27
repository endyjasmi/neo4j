<?php namespace EndyJasmi\Neo4j\Driver;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class AbstractDriverTest extends TestCase
{
    protected $id = 1;

    protected $options = [
        'scheme' => 'http',
        'host' => 'localhost',
        'port' => 7474,
        'username' => '',
        'password' => ''
    ];

    protected $request = [
        'statements' => [
            [
                'includeStats' => true,
                'statement' => 'MATCH n RETURN n'
            ]
        ]
    ];

    public function testBeginTransactionMethod()
    {
        // Given
        $driver = Mockery::mock('EndyJasmi\Neo4j\Driver\AbstractDriver[createClient]');

        $client = Mockery::mock('Buzz\Client\ClientInterface');

        $driver->shouldReceive('createClient')
            ->once()
            ->andReturn($client);

        $client->shouldReceive('send')
            ->once();

        // When
        $response = $driver->beginTransaction($this->request);

        // Expect
        $this->assertInternalType('array', $response);
    }

    public function testCommitMethod()
    {
        // Given
        $driver = Mockery::mock('EndyJasmi\Neo4j\Driver\AbstractDriver[createClient]');

        $client = Mockery::mock('Buzz\Client\ClientInterface');

        $driver->shouldReceive('createClient')
            ->once()
            ->andReturn($client);

        $client->shouldReceive('send')
            ->once();

        // When
        $response = $driver->commit($this->request, $this->id);

        // Expect
        $this->assertInternalType('array', $response);
    }

    public function testExecuteMethod()
    {
        // Given
        $driver = Mockery::mock('EndyJasmi\Neo4j\Driver\AbstractDriver[createClient]');

        $client = Mockery::mock('Buzz\Client\ClientInterface');

        $driver->shouldReceive('createClient')
            ->once()
            ->andReturn($client);

        $client->shouldReceive('send')
            ->once();

        // When
        $response = $driver->execute($this->request, $this->id);

        // Expect
        $this->assertInternalType('array', $response);
    }

    public function testGetOptionsMethod()
    {
        // Given
        $driver = Mockery::mock('EndyJasmi\Neo4j\Driver\AbstractDriver[createClient]');

        // When
        $options = $driver->getOptions();

        // Expect
        $this->assertInternalType('array', $options);
    }

    public function testGetStatusCodesPage()
    {
        // Given
        $driver = Mockery::mock('EndyJasmi\Neo4j\Driver\AbstractDriver[createClient]');

        $client = Mockery::mock('Buzz\Client\ClientInterface');

        $driver->shouldReceive('createClient')
            ->once()
            ->andReturn($client);

        $client->shouldReceive('send')
            ->once();

        $url = 'http://www.neo4j.com/docs/stable/status-codes.html';

        // When
        $content = $driver->getStatusCodesPage($url);

        // Expect
        $this->assertNull($content);
    }

    public function testRollbackMethod()
    {
        // Given
        $driver = Mockery::mock('EndyJasmi\Neo4j\Driver\AbstractDriver[createClient]');

        $client = Mockery::mock('Buzz\Client\ClientInterface');

        $driver->shouldReceive('createClient')
            ->once()
            ->andReturn($client);

        $client->shouldReceive('send')
            ->once();

        // When
        $response = $driver->rollback($this->id);

        // Expect
        $this->assertInternalType('array', $response);
    }

    public function testSetOptionsMethod()
    {
        // Given
        $driver = Mockery::mock('EndyJasmi\Neo4j\Driver\AbstractDriver[createClient]');

        // When
        $self = $driver->setOptions($this->options);

        // Expect
        $this->assertSame($driver, $self);
    }
}
