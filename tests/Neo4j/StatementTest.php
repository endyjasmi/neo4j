<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class StatementTest extends TestCase
{
    protected $parameters = [];

    protected $query = 'MATCH n RETURN n';

    public function testGetParametersMethod()
    {
        // Given
        $statement = new Statement($this->query);

        // When
        $parameters = $statement->getParameters();

        // Expect
        $this->assertInternalType('array', $parameters);
    }

    public function testGetQueryMethod()
    {
        // Given
        $statement = new Statement($this->query);

        // When
        $query = $statement->getQuery();

        // Expect
        $this->assertInternalType('string', $query);
    }

    public function testGetResultMethod()
    {
        // Given
        $statement = new Statement($this->query);

        // When
        $result = $statement->getResult();

        // Expect
        $this->assertNull($result);
    }

    public function testSetParametersMethod()
    {
        // Given
        $statement = new Statement($this->query);

        // When
        $self = $statement->setParameters($this->parameters);

        // Expect
        $this->assertSame($statement, $self);
    }

    public function testSetQueryMethod()
    {
        // Given
        $statement = new Statement($this->query);

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
        $statement = new Statement($this->query);

        // When
        $statement->setQuery(123);
    }

    public function testSetResultMethod()
    {
        // Given
        $statement = new Statement($this->query);

        $result = Mockery::mock('EndyJasmi\Neo4j\ResultInterface');

        // When
        $self = $statement->setResult($result);

        // Expect
        $this->assertSame($statement, $self);
    }
}
