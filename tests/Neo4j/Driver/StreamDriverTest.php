<?php namespace EndyJasmi\Neo4j\Driver;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class StreamDriverTest extends TestCase
{
    protected $options = [
        'scheme' => 'http',
        'host' => 'localhost',
        'port' => 7474,
        'username' => '',
        'password' => ''
    ];

    protected $request = [
        'statements' => []
    ];

    protected $response = [
        'results' => [],
        'errors' => []
    ];

    public function testBeginTransactionMethod()
    {
        // Create partial mock
        $client = Mockery::mock('EndyJasmi\Neo4j\Driver\StreamDriver[send]', [$this->options]);

        // Mock actions
        $client->shouldReceive('send')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $response = $client->beginTransaction($this->request);

        $this->assertArrayHasKey('results', $response);
        $this->assertArrayHasKey('errors', $response);
    }

    public function testCommitTransactionMethod()
    {
        // Create partial mock
        $client = Mockery::mock('EndyJasmi\Neo4j\Driver\StreamDriver[send]', [$this->options]);

        // Mock actions
        $client->shouldReceive('send')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $this->request['id'] = 1;
        $response = $client->commitTransaction($this->request);

        $this->assertArrayHasKey('results', $response);
        $this->assertArrayHasKey('errors', $response);
    }

    public function testExecuteTransactionMethod()
    {
        // Create partial mock
        $client = Mockery::mock('EndyJasmi\Neo4j\Driver\StreamDriver[send]', [$this->options]);

        // Mock actions
        $client->shouldReceive('send')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $this->request['id'] = 1;
        $response = $client->executeTransaction($this->request);

        $this->assertArrayHasKey('results', $response);
        $this->assertArrayHasKey('errors', $response);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExecuteTransactionMethodThrowsInvalidArgumentException()
    {
        // Create partial mock
        $client = Mockery::mock('EndyJasmi\Neo4j\Driver\StreamDriver[send]', [$this->options]);

        // Mock actions
        $client->shouldReceive('send')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $response = $client->executeTransaction($this->request);

        $this->assertArrayHasKey('results', $response);
        $this->assertArrayHasKey('errors', $response);
    }

    public function testRollbackTransactionMethod()
    {
        // Create partial mock
        $client = Mockery::mock('EndyJasmi\Neo4j\Driver\StreamDriver[send]', [$this->options]);

        // Mock actions
        $client->shouldReceive('send')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $this->request['id'] = 1;
        $response = $client->rollbackTransaction($this->request);

        $this->assertArrayHasKey('results', $response);
        $this->assertArrayHasKey('errors', $response);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRollbackTransactionMethodThrowsInvalidArgumentException()
    {
        // Create partial mock
        $client = Mockery::mock('EndyJasmi\Neo4j\Driver\StreamDriver[send]', [$this->options]);

        // Mock actions
        $client->shouldReceive('send')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $response = $client->rollbackTransaction($this->request);

        $this->assertArrayHasKey('results', $response);
        $this->assertArrayHasKey('errors', $response);
    }

    public function testSendMethod()
    {
        // Mock here
        $client = Mockery::mock('Buzz\Client\FileGetContents');
        $request = Mockery::mock('Buzz\Message\Request');
        $response = Mockery::mock('Buzz\Message\Response');

        $client->shouldReceive('send')
            ->once();

        $response->shouldReceive('getHeader')
            ->once()
            ->andReturn('http://localhost:7474/db/data/transaction/1');

        $response->shouldReceive('getContent')
            ->once()
            ->andReturn('{}');

        // Test start here
        $driver = new StreamDriver($this->options);

        $response = $driver->send($request, $client, $response);

        $this->assertArrayHasKey('id', $response);
    }

    public function testSetOptionsMethod()
    {
        $client = new StreamDriver($this->options);

        $return = $client->setOptions($this->options);

        $this->assertSame($client, $return);
    }
}
