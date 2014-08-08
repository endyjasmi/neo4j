<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class StatementTest extends TestCase
{
    protected $parameters;

    protected $query;

    public function setUp()
    {
        $this->query = Mockery::mock('EndyJasmi\Neo4j\Statement\Query');
        $this->parameters = Mockery::mock('EndyJasmi\Neo4j\Statement\Parameters');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testToArray()
    {
        $this->query->shouldReceive('__toString')
            ->once()
            ->andReturn('query');

        $this->parameters->shouldReceive('toArray')
            ->once()
            ->andReturn(
                array(
                    'parameter' => 'value'
                )
            );

        $statement = new Statement($this->query, $this->parameters);
        $statement = $statement->toArray();

        $this->assertArrayHasKey('statement', $statement);
        $this->assertArrayHasKey('parameters', $statement);
        $this->assertArrayHasKey('includeStats', $statement);
    }

    public function testToJson()
    {
        $this->query->shouldReceive('__toString')
            ->once()
            ->andReturn('query');

        $this->parameters->shouldReceive('toArray')
            ->once()
            ->andReturn(
                array(
                    'parameter' => 'value'
                )
            );

        $statement = new Statement($this->query, $this->parameters);
        $statement = $statement->toJson();

        $this->assertEquals(
            '{"statement":"query","parameters":{"parameter":"value"},"includeStats":true}',
            $statement
        );
    }

    public function testEmptyParameters()
    {
        $this->query->shouldReceive('__toString')
            ->once()
            ->andReturn('query');

        $this->parameters->shouldReceive('toArray')
            ->once()
            ->andReturn(array());

        $statement = new Statement($this->query, $this->parameters);
        $statement = $statement->toArray();

        $this->assertArrayHasKey('statement', $statement);
        $this->assertArrayNotHasKey('parameters', $statement);
        $this->assertArrayHasKey('includeStats', $statement);
    }
}
