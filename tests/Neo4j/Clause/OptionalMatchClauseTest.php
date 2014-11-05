<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class OptionalMatchClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetParametersMethod()
    {
        $match = new OptionalMatchClause($this->query, '(n:Person {name: {name}})', ['name' => 'John Doe']);

        $match->where('n.age = 21');

        $parameters = $match->getParameters();

        $this->assertArrayHasKey('name', $parameters);
    }

    public function testGetQueryMethod()
    {
        $match = new OptionalMatchClause($this->query, 'n');

        $match->usingScan('n:Person');
        $match->where('n.name = {name}', ['name' => 'John Doe']);

        $query = $match->getQuery();
        
        $this->assertEquals('OPTIONAL MATCH n USING SCAN n:Person WHERE n.name = {name}', $query);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testMatchMethod()
    {
        $match = new OptionalMatchClause($this->query, 'n');

        $match->match('m');
    }

    public function testOptionalMatchMethod()
    {
        $match = new OptionalMatchClause($this->query, 'n');

        $return = $match->optionalMatch('m');

        $this->assertSame($match, $return);
    }

    public function testUsingIndexMethod()
    {
        $match = new OptionalMatchClause($this->query, 'n');

        $using = $match->usingIndex('n:Person(name)');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\UsingClause', $using);

        $using = $match->usingIndex('n:Person(name)');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\UsingClause', $using);
    }

    public function testUsingScanMethod()
    {
        $match = new OptionalMatchClause($this->query, 'n');

        $using = $match->usingScan('n:Person(name)');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\UsingClause', $using);

        $using = $match->usingScan('n:Person(name)');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\UsingClause', $using);
    }

    public function testWhereMethod()
    {
        $match = new OptionalMatchClause($this->query, 'n');

        $where = $match->where('n.name = "John Doe"');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\WhereClause', $where);
    }
}
