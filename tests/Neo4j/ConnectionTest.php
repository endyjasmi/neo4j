<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ConnectionTest extends TestCase
{
    protected $builder;

    protected $container;

    protected $driver;

    protected $errors;

    protected $events;

    protected $request;

    protected $response;

    protected $requestArray = [
        'statements' => []
    ];

    protected $responseArray = [
        'results' => [],
        'errors' => []
    ];

    protected $result;

    protected $statement;

    protected $status;

    public function setUp()
    {
        $this->builder = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
        $this->container = Mockery::mock('Illuminate\Contracts\Container\Container');
        $this->driver = Mockery::mock('EndyJasmi\Neo4j\DriverInterface');
        $this->errors = Mockery::mock('EndyJasmi\Neo4j\Response\ErrorsInterface');
        $this->events = Mockery::mock('Illuminate\Contracts\Events\Dispatcher');
        $this->request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $this->response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->result = Mockery::mock('EndyJasmi\Neo4j\Response\ResultInterface');
        $this->statement = Mockery::mock('EndyJasmi\Neo4j\Request\StatementInterface');
        $this->status = Mockery::mock('EndyJasmi\Neo4j\Response\StatusInterface');
    }

    public function testBeginTransactionMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->request);

        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->requestArray);

        $this->driver->shouldReceive('beginTransaction')
            ->once()
            ->andReturn($this->responseArray);

        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $response = $connection->beginTransaction();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testBeginTransactionMethodWithRequestInstance()
    {
        // Mock actions
        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->requestArray);

        $this->driver->shouldReceive('beginTransaction')
            ->once()
            ->andReturn($this->responseArray);

        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $response = $connection->beginTransaction($this->request);

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCommitMethod()
    {
        // Mock actions
        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->requestArray);

        $this->driver->shouldReceive('commitTransaction')
            ->once()
            ->andReturn($this->responseArray);

        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $response = $connection->commit($this->request);

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCreateBuilderMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->builder);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $builder = $connection->createBuilder($connection);

        $this->assertInstanceOf('EndyJasmi\Neo4j\QueryInterface', $builder);
    }

    public function testCreateErrorMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->errors);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $errorsArray = [];
        $errors = $connection->createErrors($errorsArray);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\ErrorsInterface', $errors);
    }

    public function testCreateRequestMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->request);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $request = $connection->createRequest();

        $this->assertInstanceOf('EndyJasmi\Neo4j\RequestInterface', $request);
    }

    public function testCreateResponseMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $response = $connection->createResponse($this->request, $this->responseArray);

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCreateResultMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->result);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $resultArray = [
            'columns' => [],
            'data' => [],
            'stats' => []
        ];

        $result = $connection->createResult($this->statement, $resultArray);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\ResultInterface', $result);
    }

    public function testCreateStatementMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->statement);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $queryString = 'match n return n';
        $statement = $connection->createStatement($queryString);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Request\StatementInterface', $statement);
    }

    public function testCreateStatusMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->status);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $statusArray = [];
        $status = $connection->createStatus($this->result, $statusArray);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\StatusInterface', $status);
    }

    public function testFireMethod()
    {
        // Mock actions
        $container = Mockery::mock('Illuminate\Container\Container');

        $container->shouldReceive('offsetGet')
            ->once()
            ->andReturn($this->events);

        $this->events->shouldReceive('fire')
            ->once();

        // Test start here
        $connection = new Connection($container, $this->driver);

        $connection->fire('query', null, microtime(true));
    }

    public function testGetContainerMethod()
    {
        $connection = new Connection($this->container, $this->driver);

        $container = $connection->getContainer();

        $this->assertSame($this->container, $container);
    }

    public function testGetDriverMethod()
    {
        $connection = new Connection($this->container, $this->driver);

        $driver = $connection->getDriver();

        $this->assertSame($this->driver, $driver);
    }

    public function testExecuteMethod()
    {
        // Mock actions
        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->requestArray);

        $this->driver->shouldReceive('executeTransaction')
            ->once()
            ->andReturn($this->responseArray);

        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $response = $connection->execute($this->request);

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testListenMethod()
    {
        // Mock actions
        $container = Mockery::mock('Illuminate\Container\Container');

        $container->shouldReceive('offsetGet')
            ->once()
            ->andReturn($this->events);

        $this->events->shouldReceive('listen')
            ->once();

        // Test start here
        $connection = new Connection($container, $this->driver);

        $connection->listen(
            function () {

            }
        );
    }

    public function testRollbackMethod()
    {
        // Mock actions
        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->requestArray);

        $this->driver->shouldReceive('rollbackTransaction')
            ->once()
            ->andReturn($this->responseArray);

        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->response);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $response = $connection->rollback($this->request);

        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testSetContainerMethod()
    {
        $connection = new Connection($this->container, $this->driver);

        $return = $connection->setContainer($this->container);

        $this->assertSame($connection, $return);
    }

    public function testSetDriverMethod()
    {
        $connection = new Connection($this->container, $this->driver);

        $return = $connection->setDriver($this->driver);

        $this->assertSame($connection, $return);
    }

    public function testStatementMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->statement);

        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->request);

        $this->request->shouldReceive('pushStatement')
            ->once()
            ->andReturn($this->request);

        $this->request->shouldReceive('commit')
            ->once();

        $this->statement->shouldReceive('getResult')
            ->once()
            ->andReturn($this->result);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $queryString = 'match n return n';
        $result = $connection->statement($queryString);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\ResultInterface', $result);
    }

    public function testTransactionMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->request);

        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->requestArray);

        $this->driver->shouldReceive('beginTransaction')
            ->once()
            ->andReturn($this->responseArray);

        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->response);

        $this->response->shouldReceive('commit')
            ->once();

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $that = $this;

        $connection->transaction(
            function ($transaction) use ($that) {
                $that->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $transaction);
            }
        );
    }

    public function testRunMagicMethod()
    {
        // Mock actions
        $this->container->shouldReceive('make')
            ->once()
            ->andReturn($this->builder);

        $this->builder->shouldReceive('run')
            ->once()
            ->andReturn($this->result);

        // Test start here
        $connection = new Connection($this->container, $this->driver);

        $result = $connection->run();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\ResultInterface', $result);
    }
}
