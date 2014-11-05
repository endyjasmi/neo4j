<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class MatchClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetParametersMethod()
    {
        $match = new MatchClause($this->query, '(n:Person {name: {name}})', ['name' => 'John Doe']);

        $match->where('n.age = 21');

        $parameters = $match->getParameters();

        $this->assertArrayHasKey('name', $parameters);
    }

    public function testGetQueryMethod()
    {
        $match = new MatchClause($this->query, 'n');

        $match->usingScan('n:Person');
        $match->where('n.name = {name}', ['name' => 'John Doe']);

        $query = $match->getQuery();
        
        $this->assertEquals('MATCH n USING SCAN n:Person WHERE n.name = {name}', $query);
    }

    public function testMatchMethod()
    {
        $match = new MatchClause($this->query, 'n');

        $return = $match->match('m');

        $this->assertSame($match, $return);
    }

    public function testUsingIndexMethod()
    {
        $match = new MatchClause($this->query, 'n');

        $using = $match->usingIndex('n:Person(name)');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\UsingClause', $using);

        $using = $match->usingIndex('n:Person(name)');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\UsingClause', $using);
    }

    public function testUsingScanMethod()
    {
        $match = new MatchClause($this->query, 'n');

        $using = $match->usingScan('n:Person(name)');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\UsingClause', $using);

        $using = $match->usingScan('n:Person(name)');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\UsingClause', $using);
    }

    public function testWhereMethod()
    {
        $match = new MatchClause($this->query, 'n');

        $where = $match->where('n.name = "John Doe"');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\WhereClause', $where);
    }
}
