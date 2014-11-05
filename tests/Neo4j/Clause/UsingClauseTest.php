<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class UsingClausetest extends TestCase
{
    protected $clause;

    public function setUp()
    {
        $this->clause = Mockery::mock('EndyJasmi\Neo4j\Clause\ClauseInterface');
    }

    public function testGetQueryMethod()
    {
        $using = new UsingClause($this->clause, UsingClause::INDEX, 'n.Person(name)');

        $query = $using->getQuery();

        $this->assertEquals('USING INDEX n.Person(name)', $query);
    }

    public function testUsingIndexMethod()
    {
        $using = new UsingClause($this->clause, UsingClause::INDEX, 'n.Person(name)');

        $return = $using->usingIndex('n.Person(age)');

        $this->assertSame($using, $return);
    }

    public function testUsingScanMethod()
    {
        $using = new UsingClause($this->clause, UsingClause::INDEX, 'n.Person(name)');

        $return = $using->usingScan('n.Person');

        $this->assertSame($using, $return);
    }
}
