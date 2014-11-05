<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class RemoveClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetQueryMethod()
    {
        $remove = new RemoveClause($this->query, 'n');

        $query = $remove->getQuery();

        $this->assertEquals('REMOVE n', $query);
    }
}
