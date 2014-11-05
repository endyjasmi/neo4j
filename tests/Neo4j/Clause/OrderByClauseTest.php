<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class OrderByClauseTest extends TestCase
{
    protected $clause;

    public function setUp()
    {
        $this->clause = Mockery::mock('EndyJasmi\Neo4j\Clause\ClauseInterface');
    }

    public function testGetQueryMethod()
    {
        $order = new OrderByClause($this->clause, 'n.name', 'desc');

        $query = $order->getQuery();

        $this->assertEquals('ORDER BY n.name DESC', $query);
    }

    public function testOrderByMethod()
    {
        $order = new OrderByClause($this->clause, 'n.name', 'desc');

        $return = $order->orderBy('n.age');

        $this->assertSame($order, $return);
    }
}
