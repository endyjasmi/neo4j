<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ResponseTest extends TestCase
{
    protected $connection;

    protected $errors;

    protected $id = 1;

    protected $request;

    protected $response;

    protected $responseArray = [
        'results' => [],
        'errors' => []
    ];

    protected $statement;

    protected $result;

    public function setUp()
    {
        $this->connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');
        $this->errors = Mockery::mock('EndyJasmi\Neo4j\Response\ErrorsInterface');
        $this->request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $this->response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->result = Mockery::mock('EndyJasmi\Neo4j\Response\ResultInterface');
        $this->statement = Mockery::mock('EndyJasmi\Neo4j\Request\StatementInterface');
    }

    public function testCommitMethod()
    {
        // Sample data
        $this->responseArray['results'] = [
            [
                'columns' => ['name', 'age'],
                'data' => [],
                'stats' => []
            ]
        ];

        // Mock actions
        $request = Mockery::mock('EndyJasmi\Neo4j\Request');

        $this->connection->shouldReceive('createRequest')
            ->once()
            ->andReturn($this->request);

        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $request->shouldReceive('offsetGet')
            ->once()
            ->andReturn($this->statement);

        $this->connection->shouldReceive('createResult')
            ->once()
            ->andReturn($this->result);

        $this->connection->shouldReceive('commit')
            ->once()
            ->andReturn($this->response);

        $request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $this->responseArray['id'] = $this->id;
        $transaction = new Response($this->connection, $request, $this->responseArray);

        $response = $transaction->commit();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    /**
     * @expectedException DomainException
     */
    public function testCommitMethodThrowDomainException()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->connection->shouldReceive('commit')
            ->once()
            ->andReturn($this->response);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $transaction = new Response($this->connection, $this->request, $this->responseArray);

        $response = $transaction->commit();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCreateRequestMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        $this->connection->shouldReceive('createRequest')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $response = new Response($this->connection, $this->request, $this->responseArray);

        $request = $response->createRequest();

        $this->assertInstanceOf('EndyJasmi\Neo4j\RequestInterface', $request);
    }

    public function testGetConnectionMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $response = new Response($this->connection, $this->request, $this->responseArray);

        $connection = $response->getConnection();

        $this->assertSame($this->connection, $connection);
    }

    public function testGetErrorsMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $response = new Response($this->connection, $this->request, $this->responseArray, $this->id);

        $errors = $response->getErrors();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\ErrorsInterface', $errors);
    }

    public function testGetIdMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $response = new Response($this->connection, $this->request, $this->responseArray);

        $null = $response->getId();

        $this->assertNull($null);
    }

    public function testGetIdMethodReturnTransactionId()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $this->responseArray['id'] = $this->id;
        $response = new Response($this->connection, $this->request, $this->responseArray, $this->id);

        $id = $response->getId();

        $this->assertEquals($this->id, $id);
    }

    public function testGetRequestMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $response = new Response($this->connection, $this->request, $this->responseArray, $this->id);

        $request = $response->getRequest();

        $this->assertSame($this->request, $request);
    }

    public function testRollbackMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('createRequest')
            ->once()
            ->andReturn($this->request);

        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->connection->shouldReceive('rollback')
            ->once()
            ->andReturn($this->response);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $this->responseArray['id'] = $this->id;
        $transaction = new Response($this->connection, $this->request, $this->responseArray, $this->id);

        $response = $transaction->rollback();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    /**
     * @expectedException DomainException
     */
    public function testRollbackMethodThrowsDomainException()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $transaction = new Response($this->connection, $this->request, $this->responseArray);

        $transaction->rollback();
    }

    public function testSetConnectionMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $response = new Response($this->connection, $this->request, $this->responseArray, $this->id);

        $return = $response->setConnection($this->connection);

        $this->assertSame($response, $return);
    }

    public function testSetIdMethod()
    {
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $response = new Response($this->connection, $this->request, $this->responseArray, $this->id);

        $return = $response->setId($this->id);

        $this->assertSame($response, $return);
    }

    public function testSetRequestMethod()
    {
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->twice()
            ->andReturn($this->request);

        // Test start here
        $response = new Response($this->connection, $this->request, $this->responseArray, $this->id);

        $return = $response->setRequest($this->request);

        $this->assertSame($response, $return);
    }

    public function testStatementMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('createErrors')
            ->once()
            ->andReturn($this->errors);

        $this->request->shouldReceive('setResponse')
            ->once()
            ->andReturn($this->request);

        $this->connection->shouldReceive('createStatement')
            ->once()
            ->andReturn($this->statement);

        $this->connection->shouldReceive('createRequest')
            ->once()
            ->andReturn($this->request);

        $this->request->shouldReceive('pushStatement')
            ->once()
            ->andReturn($this->request);

        $this->request->shouldReceive('execute')
            ->once();

        $this->statement->shouldReceive('getResult')
            ->once()
            ->andReturn($this->result);

        // Test start here
        $response = new Response($this->connection, $this->request, $this->responseArray);

        $result = $response->statement('match n return n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\ResultInterface', $result);
    }
}
