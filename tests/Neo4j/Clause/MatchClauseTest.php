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

    public function testGetQueryMethod()
    {
        $match = new MatchClause($this->query, 'n');

        $match->usingIndex('n:Person(name)')
            ->usingScan('n:Person')
            ->where('n.name = {name}', ['name' => 'John Doe'])
            ->usingIndex('n:Doctor(name)')
            ->usingScan('n:Doctor');

        $query = $match->getQuery();
        
        $this->assertEquals('MATCH n USING INDEX n:Person(name) USING SCAN n:Person USING INDEX n:Doctor(name) USING SCAN n:Doctor WHERE n.name = {name}', $query);
    }

    public function testGetParametersMethod()
    {
        $match = new MatchClause($this->query, 'n');

        $match->where('n.name = {name}', ['name' => 'John Doe']);

        $parameters = $match->getParameters();

        $this->assertArrayHasKey('name', $parameters);
    }
}
