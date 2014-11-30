<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class StatementTest extends TestCase
{
    protected $parameters = [];

    protected $query = 'MATCH n RETURN n';

    public function setUp()
    {
        $this->factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');
        $this->timer = Mockery::mock('EndyJasmi\Neo4j\TimerInterface');

        $this->timer->shouldReceive('start')
            ->once();
    }

    public function testGetParametersMethod()
    {
        // Given
        $statement = new Statement($this->factory, $this->timer, $this->query, $this->parameters);

        // When
        $parameters = $statement->getParameters();

        // Expect
        $this->assertInternalType('array', $parameters);
    }

    public function testGetQueryMethod()
    {
        // Given
        $statement = new Statement($this->factory, $this->timer, $this->query, $this->parameters);

        // When
        $query = $statement->getQuery();

        // Expect
        $this->assertInternalType('string', $query);
    }

    public function testGetResultMethod()
    {
        // Given
        $statement = new Statement($this->factory, $this->timer, $this->query, $this->parameters);

        // When
        $result = $statement->getResult();

        // Expect
        $this->assertNull($result);
    }

    public function testSetParametersMethod()
    {
        // Given
        $statement = new Statement($this->factory, $this->timer, $this->query, $this->parameters);

        // When
        $self = $statement->setParameters($this->parameters);

        // Expect
        $this->assertSame($statement, $self);
    }

    public function testSetQueryMethod()
    {
        // Given
        $statement = new Statement($this->factory, $this->timer, $this->query, $this->parameters);

        // When
        $self = $statement->setQuery($this->query);

        // Expect
        $this->assertSame($statement, $self);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetQueryMethodThrowsInvalidArgumentException()
    {
        // Given
        $statement = new Statement($this->factory, $this->timer, $this->query, $this->parameters);

        // When
        $statement->setQuery(123);
    }

    public function testSetResultMethod()
    {
        // Given
        $statement = new Statement($this->factory, $this->timer, $this->query, $this->parameters);

        $result = Mockery::mock('EndyJasmi\Neo4j\ResultInterface');

        $this->timer->shouldReceive('stop')
            ->once();

        // When
        $self = $statement->setResult($result);

        // Expect
        $this->assertSame($statement, $self);
    }
}
