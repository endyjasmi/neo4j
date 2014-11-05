<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class DeleteClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetQueryMethod()
    {
        $delete = new DeleteClause($this->query, 'n');

        $query = $delete->getQuery();

        $this->assertEquals('DELETE n', $query);
    }
}
