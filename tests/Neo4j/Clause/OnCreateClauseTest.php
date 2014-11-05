<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class OnCreateClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetQueryMethod()
    {
        $onCreate = new OnCreateClause($this->query);

        $query = $onCreate->getQuery();

        $this->assertEquals('ON CREATE', $query);
    }
}
