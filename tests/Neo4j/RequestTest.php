<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class RequestTest extends TestCase
{
    protected $id = 1;

    public function setUp()
    {
        $this->factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');
        $this->connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');
    }

    public function testBeginTransactionMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->id);

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
        $request = new Request($this->factory, $this->connection, $this->id);

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
        $request = new Request($this->factory, $this->connection, $this->id);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        $this->connection->shouldReceive('execute')
            ->once()
            ->andReturn($response);

        // When
        $response = $request->execute();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testGetIdMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->id);

        // When
        $id = $request->getId();

        // Expect
        $this->assertInternalType('integer', $id);
    }

    public function testGetResponseMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->id);

        // When
        $response = $request->getResponse();

        // Expect
        $this->assertNull($response);
    }

    public function testPopStatementMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->id);

        // When
        $statement = $request->popStatement();

        // Expect
        $this->assertNull($statement);
    }

    public function testPushStatementMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->id);

        $statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');

        // When
        $self = $request->pushStatement($statement);

        // Expect
        $this->assertSame($request, $self);
    }

    public function testSetIdMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->id);

        // When
        $self = $request->setId($this->id);

        // Expect
        $this->assertSame($request, $self);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetIdMethodThrowInvalidArgumentException()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->id);

        // When
        $request->setId('abc');
    }

    public function testSetResponseMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->id);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        // When
        $self = $request->setResponse($response);

        // Expect
        $this->assertSame($request, $self);
    }

    public function testStatementMethod()
    {
        // Given
        $request = new Request($this->factory, $this->connection, $this->id);

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
        $request = new Request($this->factory, $this->connection, $this->id);

        // When
        $array = $request->toArray();

        // Expect
        $this->assertArrayHasKey('statements', $array);
    }
}
