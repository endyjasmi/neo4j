<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class QueryTest extends TestCase
{
    protected $connection;

    protected $result;

    public function setUp()
    {
        $this->connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');
        $this->result = Mockery::mock('EndyJasmi\Neo4j\Response\ResultInterface');
    }

    public function testCreateMethod()
    {
        $query = new Query($this->connection);

        $create = $query->create('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\CreateClause', $create);
    }

    public function testCreateUniqueMethod()
    {
        $query = new Query($this->connection);

        $createUnique = $query->createUnique('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\CreateUniqueClause', $createUnique);
    }

    public function testDeleteMethod()
    {
        $query = new Query($this->connection);

        $delete = $query->delete('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\DeleteClause', $delete);
    }

    public function testFirstMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('statement')
            ->once()
            ->andReturn(['result']);

        // Test start here
        $query = new Query($this->connection);

        $result = $query->first();

        $this->assertEquals('result', $result);
    }

    public function testGetMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('statement')
            ->once()
            ->andReturn($this->result);

        // Test start here
        $query = new Query($this->connection);

        $result = $query->get();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\ResultInterface', $result);
    }

    public function testGetConnectionMethod()
    {
        $query = new Query($this->connection);

        $connection = $query->getConnection();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ConnectionInterface', $connection);
    }

    public function testMatchMethod()
    {
        $query = new Query($this->connection);

        $match = $query->match('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\MatchClause', $match);
    }

    public function testMergeMethod()
    {
        $query = new Query($this->connection);

        $merge = $query->merge('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\MergeClause', $merge);
    }

    public function testOnCreateMethod()
    {
        $query = new Query($this->connection);

        $onCreate = $query->onCreate();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\OnCreateClause', $onCreate);
    }

    public function testOnMatchMethod()
    {
        $query = new Query($this->connection);

        $onMatch = $query->onMatch();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\OnMatchClause', $onMatch);
    }

    public function testOptionalMatchMethod()
    {
        $query = new Query($this->connection);

        $optionalMatch = $query->optionalMatch('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\OptionalMatchClause', $optionalMatch);
    }

    public function testOutputMethod()
    {
        $query = new Query($this->connection);

        $output = $query->output('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\OutputClause', $output);
    }

    public function testParametersMethod()
    {
        $query = new Query($this->connection);

        $parameters = $query->match('n')
            ->parameters();

        $this->assertEmpty($parameters);
    }

    public function testRemoveMethod()
    {
        $query = new Query($this->connection);

        $remove = $query->remove('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\RemoveClause', $remove);
    }

    public function testRunMethod()
    {
        // Mock actions
        $this->connection->shouldReceive('statement')
            ->once()
            ->andReturn($this->result);

        // Test start here
        $query = new Query($this->connection);

        $result = $query->run();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\ResultInterface', $result);
    }

    public function testSetMethod()
    {
        $query = new Query($this->connection);

        $set = $query->set('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\SetClause', $set);
    }

    public function testSetConnectionMethod()
    {
        $query = new Query($this->connection);

        $return = $query->setConnection($this->connection);

        $this->assertSame($query, $return);
    }

    public function testStringMethod()
    {
        $query = new Query($this->connection);

        $string = $query->match('n')->string();

        $this->assertEquals('MATCH n', $string);
    }

    public function testWithMethod()
    {
        $query = new Query($this->connection);

        $with = $query->with('n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\WithClause', $with);
    }
}
