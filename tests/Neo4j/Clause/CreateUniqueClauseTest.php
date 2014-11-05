<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class CreateUniqueClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetQueryMethod()
    {
        $create = new CreateUniqueClause($this->query, 'n');

        $query = $create->getQuery();

        $this->assertEquals('CREATE UNIQUE n', $query);
    }
}
