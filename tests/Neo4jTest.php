<?php namespace EndyJasmi;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class Neo4jTest extends TestCase
{
    protected $container;

    public function setUp()
    {
        $this->container = Mockery::mock('Illuminate\Contracts\Container\Container');
    }

    public function testConnectionMethod()
    {
        $neo4j = new Neo4j;

        $connection = $neo4j->connection();

        $this->assertInstanceOf('EndyJasmi\Neo4j\ConnectionInterface', $connection);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConnectionMethodThrowsInvalidArgumentException()
    {
        $neo4j = new Neo4j;

        $neo4j->connection('invalid');
    }

    public function testCreateCurlDriverMethod()
    {
        $neo4j = new Neo4j;

        $driver = $neo4j->createCurlDriver();

        $this->assertInstanceOf('EndyJasmi\Neo4j\DriverInterface', $driver);
    }

    public function testCreateStreamDriverMethod()
    {
        $neo4j = new Neo4j;

        $driver = $neo4j->createStreamDriver();

        $this->assertInstanceOf('EndyJasmi\Neo4j\DriverInterface', $driver);
    }

    public function testGetDefaultDriverMethod()
    {
        $neo4j = new Neo4j;

        $driver = $neo4j->getDefaultDriver();

        $this->assertInternalType('string', $driver);
    }

    public function testGetDefaultProfileMethod()
    {
        $neo4j = new Neo4j;

        $driver = $neo4j->getDefaultProfile();

        $this->assertInternalType('string', $driver);
    }

    public function testCreateStatementMagicMethod()
    {
        $neo4j = new Neo4j;

        $statement = $neo4j->createStatement('match n return n');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Request\StatementInterface', $statement);
    }
}
