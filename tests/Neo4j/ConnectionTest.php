<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ConnectionTest extends TestCase
{
    protected $output = [
        1,
        [
            'errors' => [],
            'results' => []
        ]
    ];

    protected $request = [
        'statements' => []
    ];

    public function setUp()
    {
        $this->factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');
        $this->driver = Mockery::mock('EndyJasmi\Neo4j\DriverInterface');
    }

    public function testBeginTransactionMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        $this->factory->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        $request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->request);

        $this->driver->shouldReceive('beginTransaction')
            ->once()
            ->andReturn($this->output);

        $this->factory->shouldReceive('createResponse')
            ->once()
            ->andReturn($response);

        $request->shouldReceive('setResponse')
            ->once();

        // When
        $response = $connection->beginTransaction();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCommitMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        $request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->request);

        $request->shouldReceive('getId')
            ->once()
            ->andReturn(1);

        $this->driver->shouldReceive('commit')
            ->once()
            ->andReturn($this->output);

        $this->factory->shouldReceive('createResponse')
            ->once()
            ->andReturn($response);

        $request->shouldReceive('setResponse')
            ->once();

        // When
        $response = $connection->commit($request);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCreateRequestMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');

        $this->factory->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        // When
        $request = $connection->createRequest(1);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\RequestInterface', $request);
    }

    public function testExecuteMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        $request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->request);

        $request->shouldReceive('getId')
            ->once()
            ->andReturn(1);

        $this->driver->shouldReceive('execute')
            ->once()
            ->andReturn($this->output);

        $this->factory->shouldReceive('createResponse')
            ->once()
            ->andReturn($response);

        $request->shouldReceive('setResponse')
            ->once();

        // When
        $response = $connection->execute($request);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testGetDriverMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        // When
        $driver = $connection->getDriver();

        // Expect
        $this->assertSame($this->driver, $driver);
    }

    public function testGetTransactionMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        // When
        $transaction = $connection->getTransaction();

        // Expect
        $this->assertNull($transaction);
    }

    public function testPopTransactionMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        // When
        $transaction = $connection->popTransaction();

        // Expect
        $this->assertNull($transaction);
    }

    public function testPushTransactionMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $transaction = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        // When
        $self = $connection->pushTransaction($transaction);

        // Expect
        $this->assertSame($connection, $self);
    }

    public function testRollbackMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');

        $request->shouldReceive('getId')
            ->once()
            ->andReturn(1);

        $this->driver->shouldReceive('rollback')
            ->once()
            ->andReturn($this->output);

        $this->factory->shouldReceive('createResponse')
            ->once()
            ->andReturn($response);

        $request->shouldReceive('setResponse')
            ->once();

        // When
        $response = $connection->rollback($request);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testSetDriverMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        // When
        $self = $connection->setDriver($this->driver);

        // Expect
        $this->assertSame($connection, $self);
    }

    public function testStatementMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $query = 'MATCH n RETURN n';
        $statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');
        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $result = Mockery::mock('EndyJasmi\Neo4j\ResultInterface');

        $this->factory->shouldReceive('createStatement')
            ->once()
            ->andReturn($statement);

        $this->factory->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        $request->shouldReceive('pushStatement')
            ->once()
            ->andReturn($request);

        $request->shouldReceive('commit')
            ->once();

        $statement->shouldReceive('getResult')
            ->once()
            ->andReturn($result);

        // When
        $result = $connection->statement($query);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResultInterface', $result);
    }
}
