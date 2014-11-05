<?php namespace EndyJasmi\Neo4j\Clause;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class OutputClauseTest extends TestCase
{
    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\QueryInterface');
    }

    public function testGetParametersMethod()
    {
        $output = new OutputClause($this->query, 'n');

        $output->skip(0)
            ->limit(50);

        $parameters = $output->getParameters();

        $this->assertArrayHasKey('skip', $parameters);
        $this->assertArrayHasKey('limit', $parameters);
    }

    public function testGetQueryMethod()
    {
        $output = new OutputClause($this->query, 'n', 'entity');

        $output->orderBy('entity.name')
            ->skip(0)
            ->limit(50);

        $query = $output->getQuery();

        $this->assertEquals('RETURN n AS entity ORDER BY entity.name SKIP {skip} LIMIT {limit}', $query);
    }

    public function testLimitMethod()
    {
        $output = new OutputClause($this->query, 'n');

        $limit = $output->limit(50);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\LimitClause', $limit);
    }

    public function testOrderByMethod()
    {
        $output = new OutputClause($this->query, 'n');

        $order = $output->orderBy('n.name');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\OrderByClause', $order);

        $order = $output->orderBy('n.name');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\OrderByClause', $order);
    }

    public function testOutputMethod()
    {
        $output = new OutputClause($this->query, 'n');

        $return = $output->output('m');

        $this->assertSame($output, $return);
    }

    public function testSkipMethod()
    {
        $output = new OutputClause($this->query, 'n');

        $skip = $output->skip(0);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Clause\SkipClause', $skip);
    }
}
