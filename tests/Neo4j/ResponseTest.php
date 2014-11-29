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

    public function testGetErrorsMethod()
    {
        // Given
        $response = new Response($this->factory, $this->request, $this->response);

        // When
        $errors = $response->getErrors();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ErrorInterface', $errors);
    }

    public function testGetRequestMethod()
    {
        // Given
        $response = new Response($this->factory, $this->request, $this->response);

        // When
        $request = $response->getRequest();

        // Expect
        $this->assertSame($this->request, $request);
    }

    public function testSetRequestMethod()
    {
        // Given
        $response = new Response($this->factory, $this->request, $this->response);

        // When
        $self = $response->setRequest($this->request);

        // Expect
        $this->assertSame($response, $self);
    }
}
