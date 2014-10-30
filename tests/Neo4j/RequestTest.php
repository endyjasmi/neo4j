<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class RequestTest extends TestCase
{
    protected $connection;

    protected $id = 1;

    protected $response;

    protected $statement;

    public function setUp()
    {
        $this->connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');
        $this->response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->statement = Mockery::mock('EndyJasmi\Neo4j\Request\StatementInterface');
    }

    public function testBeginTransactionMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('beginTransaction')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $request = new Request($this->connection);

        $response = $request->beginTransaction();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCommitMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('commit')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $request = new Request($this->connection);

        $response = $request->commit();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testExecuteMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('execute')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $request = new Request($this->connection);

        $response = $request->execute();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testGetConnectionMethod()
    {
        $request = new Request($this->connection);

        $connection = $request->getConnection();

        $this->assertSame($this->connection, $connection);
    }

    public function testGetIdMethod()
    {
        $request = new Request($this->connection);

        $null = $request->getId();

        $this->assertNull($null);
    }

    public function testGetIdMethodReturnTransactionId()
    {
        $request = new Request($this->connection, $this->id);

        $id = $request->getId();

        $this->assertEquals($this->id, $id);
    }

    public function testGetResponseMethod()
    {
        $request = new Request($this->connection);

        $null = $request->getResponse();

        $this->assertNull($null);
    }

    public function testPushStatementMethod()
    {
        $request = new Request($this->connection);

        $return = $request->pushStatement($this->statement);

        $this->assertSame($request, $return);

        return $request;
    }

    public function testSetConnectionMethod()
    {
        $request = new Request($this->connection);

        $return = $request->setConnection($this->connection);

        $this->assertSame($request, $return);
    }

    public function testSetIdMethod()
    {
        $request = new Request($this->connection);

        $return = $request->setId($this->id);

        $this->assertSame($request, $return);
    }

    public function testSetResponseMethod()
    {
        $request = new Request($this->connection);

        $return = $request->setResponse($this->response);

        $this->assertSame($request, $return);

        return $request;
    }

    public function testStatementMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('createStatement')
            ->once()
            ->andReturn($this->statement);

        // Test start here
        $request = new Request($this->connection);

        $return = $request->statement('match n return n');

        $this->assertSame($request, $return);
    }

    public function testToArrayMethod()
    {
        $request = new Request($this->connection);
        $request->setId($this->id);

        $array = $request->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('statements', $array);
    }

    /**
     * @depends testPushStatementMethod
     */
    public function testPopStatementMethod($request)
    {
        $statement = $request->popStatement();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Request\StatementInterface', $statement);
    }

    /**
     * @depends testSetResponseMethod
     */
    public function testGetResponseMethodReturnResponseInstance($request)
    {
        $response = $request->getResponse();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }
}
