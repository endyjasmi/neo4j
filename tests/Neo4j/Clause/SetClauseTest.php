<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class SetClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetQueryMethod()
    {
        $set = new SetClause($this->query, 'n');

        $query = $set->getQuery();

        $this->assertEquals('SET n', $query);
    }
}
