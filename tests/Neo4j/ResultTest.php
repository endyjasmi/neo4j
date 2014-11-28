<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ResultTest extends TestCase
{
    protected $result = [
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
    ];

    public function setUp()
    {
        $this->factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');
        $this->statement = Mockery::mock('EndyJasmi\Neo4j\StatementInterface');
    }

    public function testGetStatementMethod()
    {
        // Given
        $result = new Result($this->factory, $this->statement, $this->result);

        // When
        $statement = $result->getStatement();

        // Expect
        $this->assertSame($this->statement, $statement);
    }

    public function testGetStatusMethod()
    {
        // Given
        $result = new Result($this->factory, $this->statement, $this->result);

        $status = Mockery::mock('EndyJasmi\Neo4j\StatusInterface');
        $this->factory->shouldReceive('createStatus')
            ->once()
            ->andReturn($status);

        // When
        $status = $result->getStatus();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\StatusInterface', $status);
    }

    public function testSetStatementMethod()
    {
        // Given
        $result = new Result($this->factory, $this->statement, $this->result);

        // When
        $self = $result->setStatement($this->statement);

        // Expect
        $this->assertSame($result, $self);
    }
}
