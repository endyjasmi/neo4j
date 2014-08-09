<?php namespace EndyJasmi;

use EndyJasmi\Neo4j\Connection;
use PHPUnit_Framework_TestCase as TestCase;

class Neo4jTest extends TestCase
{
    protected $config = array(
        'other' => array(
            'host' => 'http://localhost:7474'
        )
    );

    public function testConnection()
    {
        $neo4j = new Neo4j($this->config);

        $default = $neo4j->connection('other');

        $this->assertInstanceOf('EndyJasmi\Neo4j\Connection', $default);
    }

    public function testMagicCalling()
    {
        $neo4j = new Neo4j($this->config);

        $transaction = $neo4j->getTransaction();

        $this->assertEquals(
            'http://localhost:7474/db/data/transaction/commit',
            $transaction
        );
    }
}
