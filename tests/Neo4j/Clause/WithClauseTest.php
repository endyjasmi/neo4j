<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class WithClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetParametersMethod()
    {
        $with = new WithClause($this->query, 'n');

        $with->where('n.name = {name}', ['name' => 'John Doe'])->skip(0)
            ->limit(50);

        $parameters = $with->getParameters();

        $this->assertArrayHasKey('name', $parameters);
    }

    public function testGetQueryMethod()
    {
        $with = new WithClause($this->query, 'n', 'entity');

        $with->where('entity.name = {name}', ['name' => 'John Doe']);
        $with->orderBy('entity.name');
        $with->skip(0);
        $with->limit(50);

        $query = $with->getQuery();

        $this->assertEquals(
            'WITH n AS entity WHERE entity.name = {name} ORDER BY entity.name SKIP {skip} LIMIT {limit}',
            $query
        );
    }

    public function testLimitMethod()
    {
        $with = new WithClause($this->query, 'n');

        $limit = $with->limit(50);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\LimitClause', $limit);
    }

    public function testOrderByMethod()
    {
        $with = new WithClause($this->query, 'n');

        $order = $with->orderBy('n.name');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\OrderByClause', $order);

        $order = $with->orderBy('n.name');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\OrderByClause', $order);
    }

    public function testSkipMethod()
    {
        $with = new WithClause($this->query, 'n');

        $skip = $with->skip(0);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\SkipClause', $skip);
    }

    public function testWhereMethod()
    {
        $with = new WithClause($this->query, 'n');

        $where = $with->where('n.name = {name}', ['name' => 'John Doe']);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\WhereClause', $where);
    }

    public function testWithMethod()
    {
        $with = new WithClause($this->query, 'n');

        $return = $with->with('m');

        $this->assertSame($with, $return);
    }
}
