<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ResponseTest extends TestCase
{
    protected $response = [
        'results' => [
            [
                'columns' => ['name', 'age'],
                'data' => [
                    ['row' => ['Jeffrey Jasmi', 27]],
                    ['row' => ['Endy Jasmi', 24]],
                    ['row' => ['Donney Jasmi', 19]]
                ],
                'stats' => [
                    'constraints_added' => 0,
                    'constraints_removed' => 0,
                    'contains_updates' => false,
                    'indexes_added' => 0,
                    'indexes_removed' => 0,
                    'labels_added' => 0,
                    'labels_removed' => 0,
                    'nodes_created' => 0,
                    'nodes_deleted' => 0,
                    'properties_set' => 0,
                    'relationship_deleted' => 0,
                    'relationships_created' => 0
                ]
            ]
        ],
        'errors' => []
    ];

    public function setUp()
    {
        $this->factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');
        $this->connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');
        $this->request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');

        // Constructor mock actions
        $error = Mockery::mock('EndyJasmi\Neo4j\ErrorInterface');
        $statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');
        $result = Mockery::mock('EndyJasmi\Neo4j\ResultInterface');

        $this->factory->shouldReceive('createError')
            ->once()
            ->andReturn($error);

        $this->request->shouldReceive('offsetGet')
            ->once()
            ->andReturn($statement);

        $this->factory->shouldReceive('createResult')
            ->once()
            ->andReturn($result);


        $statement->shouldReceive('setResult')
            ->once();
    }

    public function testCommitMethod()
    {
        // Given
        $response = new Response($this->factory, $this->connection, $this->request, $this->response);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $this->connection->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        $commitResponse = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $request->shouldReceive('commit')
            ->once()
            ->andReturn($commitResponse);

        // When
        $response = $response->commit();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testCreateRequestMethod()
    {
        // Given
        $response = new Response($this->factory, $this->connection, $this->request, $this->response);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $this->connection->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        // When
        $request = $response->createRequest();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\RequestInterface', $request);
    }

    public function testGetErrorsMethod()
    {
        // Given
        $response = new Response($this->factory, $this->connection, $this->request, $this->response);

        // When
        $errors = $response->getErrors();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ErrorInterface', $errors);
    }

    public function testGetRequestMethod()
    {
        // Given
        $response = new Response($this->factory, $this->connection, $this->request, $this->response);

        // When
        $request = $response->getRequest();

        // Expect
        $this->assertSame($this->request, $request);
    }

    public function testRollbackMethod()
    {
        // Given
        $response = new Response($this->factory, $this->connection, $this->request, $this->response);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $this->connection->shouldReceive('createRequest')
            ->once()
            ->andReturn($request);

        $rollbackResponse = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->connection->shouldReceive('rollback')
            ->once()
            ->andReturn($rollbackResponse);

        // When
        $response = $response->rollback();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testSetRequestMethod()
    {
        // Given
        $response = new Response($this->factory, $this->connection, $this->request, $this->response);

        // When
        $self = $response->setRequest($this->request);

        // Expect
        $this->assertSame($response, $self);
    }

    public function testStatementMethod()
    {
        // Given
        $response = new Response($this->factory, $this->connection, $this->request, $this->response);

        $statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');
        $this->factory->shouldReceive('createStatement')
            ->once()
            ->andReturn($statement);

        $request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');
        $this->connection->shouldReceive('createRequest')
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
        $result = $response->statement($query);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResultInterface', $result);
    }
}
