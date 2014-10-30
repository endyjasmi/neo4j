<?php namespace EndyJasmi\Neo4j\Request;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class StatementTest extends TestCase
{
    protected $parameters = [
        'person' => [
            'name' => 'Endy Jasmi',
            'age' => 24
        ]
    ];

    protected $query = 'create (n:Person {person}) return n';

    protected $result;

    public function setUp()
    {
        $this->result = Mockery::mock('EndyJasmi\Neo4j\Response\ResultInterface');
    }

    public function testGetParametersMethod()
    {
        $statement = new Statement($this->query, $this->parameters);

        $parameters = $statement->getParameters();

        $this->assertSame($this->parameters, $parameters);
    }

    public function testGetParametersMethodReturnNull()
    {
        $statement = new Statement($this->query);

        $null = $statement->getParameters();

        $this->assertNull($null);
    }

    public function testGetQueryMethod()
    {
        $statement = new Statement($this->query);

        $query = $statement->getQuery();

        $this->assertEquals($this->query, $query);
    }

    public function testGetResultMethod()
    {
        $statement = new Statement($this->query);

        $null = $statement->getResult();

        $this->assertNull($null);
    }

    public function testGetTimeMethod()
    {
        $statement = new Statement($this->query);

        $null = $statement->getTime();

        $this->assertNull($null);
    }

    public function testSetParametersMethod()
    {
        $statement = new Statement($this->query);

        $return = $statement->setParameters($this->parameters);

        $this->assertSame($statement, $return);
    }

    public function testSetQueryMethod()
    {
        $statement = new Statement($this->query);

        $return = $statement->setQuery($this->query);

        $this->assertSame($statement, $return);
    }

    public function testSetResultMethod()
    {
        $statement = new Statement($this->query);

        $return = $statement->setResult($this->result);

        $this->assertSame($statement, $return);

        return $statement;
    }

    /**
     * @depends testSetResultMethod
     */
    public function testGetResultMethodReturnResultInstance($statement)
    {
        $result = $statement->getResult();

        $this->assertInstanceOf('EndyJasmi\Neo4j\Response\ResultInterface', $result);
    }

    /**
     * @depends testSetResultMethod
     */
    public function testGetTimeMethodReturnFloat($statement)
    {
        $time = $statement->getTime();

        $this->assertInternalType('float', $time);
    }
}
