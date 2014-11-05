<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class OnMatchClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetQueryMethod()
    {
        $onMatch = new OnMatchClause($this->query);

        $query = $onMatch->getQuery();

        $this->assertEquals('ON MATCH', $query);
    }
}
