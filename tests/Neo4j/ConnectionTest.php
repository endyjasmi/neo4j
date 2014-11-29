<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ConnectionTest extends TestCase
{
    protected $input = [
        'statements' => []
    ];

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
        $this->factory->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        $transaction = Mockery::mock('EndyJasmi\Neo4j\TransactionInterface');
        $this->factory->shouldReceive('createTransaction')
            ->once()
            ->andReturn($transaction);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $transaction->shouldReceive('getResponse')
            ->once()
            ->andReturn($response);

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
        $this->factory->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        $transaction = Mockery::mock('EndyJasmi\Neo4j\TransactionInterface');
        $this->factory->shouldReceive('createTransaction')
            ->once()
            ->andReturn($transaction);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $transaction->shouldReceive('getResponse')
            ->once()
            ->andReturn($response);

        $transaction->shouldReceive('commit')
            ->once()
            ->andReturn($response);

        $connection->beginTransaction();

        // When
        $response = $connection->commit();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCommitMethodWithoutTransaction()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');

        $request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->input);

        $this->driver->shouldReceive('commit')
            ->once()
            ->andReturn($this->output);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->factory->shouldReceive('createResponse')
            ->once()
            ->andReturn($response);

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
        $request = $connection->createRequest();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\RequestInterface', $request);
    }

    public function testExecuteMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $this->factory->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        $transaction = Mockery::mock('EndyJasmi\Neo4j\TransactionInterface');
        $this->factory->shouldReceive('createTransaction')
            ->once()
            ->andReturn($transaction);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $transaction->shouldReceive('getResponse')
            ->once()
            ->andReturn($response);

        $transaction->shouldReceive('execute')
            ->once()
            ->andReturn($response);

        $connection->beginTransaction();

        // When
        $response = $connection->execute($request);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testExecuteMethodWithoutTransaction()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');

        $request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->input);

        $this->driver->shouldReceive('commit')
            ->once()
            ->andReturn($this->output);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->factory->shouldReceive('createResponse')
            ->once()
            ->andReturn($response);

        // When
        $response = $connection->execute($request);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
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
        $transaction = $connection->getTransaction();

        // Expect
        $this->assertNull($transaction);
    }

    public function testPushTransactionMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $transaction = Mockery::mock('EndyJasmi\Neo4j\TransactionInterface');

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
        $this->factory->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        $transaction = Mockery::mock('EndyJasmi\Neo4j\TransactionInterface');
        $this->factory->shouldReceive('createTransaction')
            ->once()
            ->andReturn($transaction);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $transaction->shouldReceive('getResponse')
            ->once()
            ->andReturn($response);

        $transaction->shouldReceive('rollback')
            ->once();

        $connection->beginTransaction();

        // When
        $null = $connection->rollback();

        // Expect
        $this->assertNull($null);
    }

    public function testStatementMethod()
    {
        // Given
        $connection = new Connection($this->factory, $this->driver);

        $statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');
        $this->factory->shouldReceive('createStatement')
            ->once()
            ->andReturn($statement);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $this->factory->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        $request->shouldReceive('pushStatement')
            ->once()
            ->andReturn($request);

        $request->shouldReceive('execute')
            ->once();

        $result = Mockery::mock('EndyJasmi\Neo4j\ResultInterface');
        $statement->shouldReceive('getResult')
            ->once()
            ->andReturn($result);

        $query = 'MATCH n RETURN n';

        // When
        $result = $connection->statement($query);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResultInterface', $result);
    }
}
