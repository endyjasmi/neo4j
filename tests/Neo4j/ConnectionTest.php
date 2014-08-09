<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ConnectionTest extends TestCase
{
    protected $driver;

    protected $response;

    public function setUp()
    {
        $this->driver = Mockery::mock('Buzz\Client\AbstractClient');
        $this->response = Mockery::mock('Buzz\Message\Response');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetDriver()
    {
        $connection = new Connection;
        $driver = $connection->getDriver();

        $this->assertInstanceOf('Buzz\Client\AbstractClient', $driver);
    }

    public function testGetTransaction()
    {
        $connection = new Connection;
        $transaction = $connection->getTransaction();

        $this->assertEquals('http://localhost:7474/db/data/transaction/commit', $transaction);
    }

    public function testStatement()
    {
        $connection = new Connection;
        $return = $connection->statement('query');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Connection', $return);
    }

    public function testCreateRequest()
    {
        $connection = new Connection;
        $request = $connection->createRequest('post', 'http://localhost:7474');

        $this->assertInstanceOf('Buzz\Message\Request', $request);
    }

    public function testCreateResponse()
    {
        $connection = new Connection;
        $response = $connection->createResponse();

        $this->assertInstanceOf('Buzz\Message\Response', $response);
    }

    public function testBeginTransaction()
    {
        $connection = Mockery::mock('EndyJasmi\Neo4j\Connection[createResponse,getDriver]');
        $connection->shouldReceive('createResponse')
            ->once()
            ->andReturn($this->response);
        $connection->shouldReceive('getDriver')
            ->once()
            ->andReturn($this->driver);

        $this->response->shouldReceive('getHeader')
            ->with('Location')
            ->once();
        $this->response->shouldReceive('getContent')
            ->once()
            ->andReturn('{"results":[],"errors":[]}');

        $this->driver->shouldReceive('send')
            ->once();

        $response = $connection->beginTransaction();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response', $response);
    }

    public function testCommit()
    {
        $connection = Mockery::mock('EndyJasmi\Neo4j\Connection[createResponse,getDriver]');
        $connection->shouldReceive('createResponse')
            ->once()
            ->andReturn($this->response);
        $connection->shouldReceive('getDriver')
            ->once()
            ->andReturn($this->driver);

        $this->response->shouldReceive('getContent')
            ->once()
            ->andReturn('{"results":[],"errors":[]}');

        $this->driver->shouldReceive('send')
            ->once();

        $response = $connection->commit();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response', $response);
    }

    public function testExecute()
    {
        $connection = Mockery::mock('EndyJasmi\Neo4j\Connection[createResponse,getDriver]');
        $connection->shouldReceive('createResponse')
            ->once()
            ->andReturn($this->response);
        $connection->shouldReceive('getDriver')
            ->once()
            ->andReturn($this->driver);

        $this->response->shouldReceive('getContent')
            ->once()
            ->andReturn('{"results":[],"errors":[]}');

        $this->driver->shouldReceive('send')
            ->once();

        $response = $connection->execute();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response', $response);
    }

    public function testRollback()
    {
        $connection = Mockery::mock('EndyJasmi\Neo4j\Connection[createResponse,getDriver]');
        $connection->shouldReceive('createResponse')
            ->once()
            ->andReturn($this->response);
        $connection->shouldReceive('getDriver')
            ->once()
            ->andReturn($this->driver);

        $this->response->shouldReceive('getContent')
            ->once()
            ->andReturn('{"results":[],"errors":[]}');

        $this->driver->shouldReceive('send')
            ->once();

        $response = $connection->execute();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response', $response);
    }
}
