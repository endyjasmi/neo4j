<?php namespace EndyJasmi\Neo4j\Response;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ResultTest extends TestCase
{
    protected $connection;

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

    protected $statement;

    protected $status;

    public function setUp()
    {
        $this->connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');
        $this->statement = Mockery::mock('EndyJasmi\Neo4j\Request\StatementInterface');
        $this->status = Mockery::mock('EndyJasmi\Neo4j\Response\StatusInterface');
    }

    public function testGetConnectionMethod()
    {
        // Mock actions
        $this->statement->shouldReceive('setResult')
            ->once()
            ->andReturn($this->statement);

        $this->statement->shouldReceive('getQuery')
            ->once();

        $this->statement->shouldReceive('getParameters')
            ->once();

        $this->statement->shouldReceive('getTime')
            ->once();

        $this->connection->shouldReceive('fire')
            ->once();

        // Test start here
        $result = new Result($this->connection, $this->statement, $this->result);

        $connection = $result->getConnection();

        $this->assertSame($this->connection, $connection);
    }

    public function testGetStatementMethod()
    {
        // Mock actions
        $this->statement->shouldReceive('setResult')
            ->once()
            ->andReturn($this->statement);

        $this->statement->shouldReceive('getQuery')
            ->once();

        $this->statement->shouldReceive('getParameters')
            ->once();

        $this->statement->shouldReceive('getTime')
            ->once();

        $this->connection->shouldReceive('fire')
            ->once();

        // Test start here
        $result = new Result($this->connection, $this->statement, $this->result);

        $statement = $result->getStatement();

        $this->assertSame($this->statement, $statement);
    }

    public function testGetStatusMethod()
    {
        // Mock actions
        $this->statement->shouldReceive('setResult')
            ->once()
            ->andReturn($this->statement);

        $this->connection->shouldReceive('createStatus')
            ->once()
            ->andReturn($this->status);

        $this->statement->shouldReceive('getQuery')
            ->once();

        $this->statement->shouldReceive('getParameters')
            ->once();

        $this->statement->shouldReceive('getTime')
            ->once();

        $this->connection->shouldReceive('fire')
            ->once();

        // Test start here
        $result = new Result($this->connection, $this->statement, $this->result);

        $status = $result->getStatus();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\StatusInterface', $status);
    }

    public function testSetConnectionMethod()
    {
        // Mock actions
        $this->statement->shouldReceive('setResult')
            ->once()
            ->andReturn($this->statement);

        $this->statement->shouldReceive('getQuery')
            ->once();

        $this->statement->shouldReceive('getParameters')
            ->once();

        $this->statement->shouldReceive('getTime')
            ->once();

        $this->connection->shouldReceive('fire')
            ->once();

        // Test start here
        $result = new Result($this->connection, $this->statement, $this->result);

        $return = $result->setConnection($this->connection);

        $this->assertSame($result, $return);
    }

    public function testSetStatementMethod()
    {
        // Mock actions
        $this->statement->shouldReceive('setResult')
            ->once()
            ->andReturn($this->statement);

        $this->statement->shouldReceive('getQuery')
            ->once();

        $this->statement->shouldReceive('getParameters')
            ->once();

        $this->statement->shouldReceive('getTime')
            ->once();

        $this->connection->shouldReceive('fire')
            ->once();

        // Test start here
        $result = new Result($this->connection, $this->statement, $this->result);

        $return = $result->setStatement($this->statement);

        $this->assertSame($result, $return);
    }
}
