<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class RequestTest extends TestCase
{
    public function setUp()
    {
        $this->factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');
        $this->connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');
        $this->transaction = Mockery::mock('EndyJasmi\Neo4j\TransactionInterface');
    }

    public function testBeginTransactionMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        $this->connection->shouldReceive('beginTransaction')
            ->once()
            ->andReturn($response);

        // When
        $response = $request->beginTransaction();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCommitMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        $this->connection->shouldReceive('commit')
            ->once()
            ->andReturn($response);

        // When
        $response = $request->commit();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testExecuteMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        $this->connection->shouldReceive('execute')
            ->once()
            ->andReturn($response);

        // When
        $response = $request->execute();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testGetConnectionMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        // When
        $connection = $request->getConnection();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ConnectionInterface', $connection);
    }

    public function testGetResponseMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        // When
        $response = $request->getResponse();

        // Expect
        $this->assertNull($response);
    }

    public function testPopStatementMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        // When
        $statement = $request->popStatement();

        // Expect
        $this->assertNull($statement);
    }

    public function testPushStatementMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        $statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');

        // When
        $self = $request->pushStatement($statement);

        // Expect
        $this->assertSame($request, $self);
    }

    public function testSetConnectionMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        // When
        $self = $request->setConnection($this->connection);

        // Expect
        $this->assertSame($request, $self);
    }

    public function testSetResponseMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        // When
        $self = $request->setResponse($response);

        // Expect
        $this->assertSame($request, $self);
    }

    public function testStatementMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        $query = 'MATCH n RETURN n';

        $statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');

        $this->factory->shouldReceive('createStatement')
            ->once()
            ->andReturn($statement);

        // When
        $self = $request->statement($query);

        // Expect
        $this->assertSame($request, $self);
    }

    public function testToArrayMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->transaction);

        // When
        $array = $request->toArray();

        // Expect
        $this->assertArrayHasKey('statements', $array);
    }
}
