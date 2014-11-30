<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class FactoryTest extends TestCase
{
    public function setUp()
    {
        $this->container = Mockery::mock('Illuminate\Container\Container');

        $this->container->shouldReceive('offsetExists')
            ->once()
            ->andReturn(false);

        $this->container->shouldReceive('bindShared')
            ->once();

        $this->container->shouldReceive('bind')
            ->times(10);

        $dispatcher = Mockery::mock('Illuminate\Events\Dispatcher');
        $this->container->shouldReceive('offsetGet')
            ->once()
            ->andReturn($dispatcher);

        $event = Mockery::mock('EndyJasmi\Neo4j\EventInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($event);
    }

    public function testCreateConnectionMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($connection);

        $driver = Mockery::mock('EndyJasmi\Neo4j\DriverInterface');

        // When
        $connection = $factory->createConnection($driver);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ConnectionInterface', $connection);
    }

    public function testCreateErrorMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $error = Mockery::mock('EndyJasmi\Neo4j\ErrorInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($error);

        $errors = [];

        // When
        $errors = $factory->createError($errors);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ErrorInterface', $errors);
    }

    public function testCreateEventMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $dispatcher = Mockery::mock('Illuminate\Events\Dispatcher');
        $this->container->shouldReceive('offsetGet')
            ->once()
            ->andReturn($dispatcher);

        $event = Mockery::mock('EndyJasmi\Neo4j\EventInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($event);

        // When
        $event = $factory->createEvent();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\EventInterface', $event);
    }

    public function testCreateExceptionMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $error = [
            'code' => 'Neo.ClientError.Statement.InvalidSyntax',
            'message' => ''
        ];

        // When
        $exception = $factory->createException($error);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax', $exception);
    }

    public function testRequestMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($request);

        $connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');

        // When
        $request = $factory->createRequest($connection);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\RequestInterface', $request);
    }

    public function testCreateResponseMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($response);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $response = [
            'errors' => [],
            'results' => []
        ];

        // When
        $response = $factory->createResponse($request, $response);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCreateResultMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $result = Mockery::mock('EndyJasmi\Neo4j\ResultInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($result);

        $statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');
        $result = [
            'columns' => [],
            'data' => [],
            'stats' => []
        ];

        // When
        $result = $factory->createResult($statement, $result);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResultInterface', $result);
    }

    public function testCreateStatementMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $timer = Mockery::mock('EndyJasmi\Neo4j\TimerInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($timer);

        $statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($statement);

        $query = 'MATCH n RETURN n';

        // When
        $statement = $factory->createStatement($query);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\StatementInterface', $statement);
    }

    public function testCreateStatusMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $status = Mockery::mock('EndyJasmi\Neo4j\StatusInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($status);

        $status = [];

        // When
        $status = $factory->createStatus($status);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\StatusInterface', $status);
    }

    public function testCreateTimerMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $timer = Mockery::mock('EndyJasmi\Neo4j\TimerInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($timer);

        // When
        $timer = $factory->createTimer();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\TimerInterface', $timer);
    }

    public function testCreateTransactionMethod()
    {
        // Given
        $factory = new Factory($this->container);

        $transaction = Mockery::mock('EndyJasmi\Neo4j\TransactionInterface');
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($transaction);

        $driver = Mockery::mock('EndyJasmi\Neo4j\DriverInterface');
        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');

        // When
        $transaction = $factory->createTransaction($driver, $request);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\TransactionInterface', $transaction);
    }

    public function testGetContainerMethod()
    {
        // Given
        $factory = new Factory($this->container);

        // When
        $container = $factory->getContainer();

        // Expect
        $this->assertSame($this->container, $container);
    }

    public function testSetContainerMethod()
    {
        // Given
        $factory = new Factory($this->container);

        // When
        $self = $factory->setContainer($this->container);

        // Expect
        $this->assertSame($factory, $self);
    }

    public function testArrayAccess()
    {
        // Given
        $factory = new Factory;

        // When
        $factory['test'] = function () {
            return 'test';
        };

        $test = $factory['test'];

        unset($factory['test']);

        $false = isset($factory['test']);

        // Expect
        $this->assertEquals('test', $test);
        $this->assertFalse($false);
    }
}
