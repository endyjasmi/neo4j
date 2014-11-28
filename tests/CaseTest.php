<?php namespace EndyJasmi;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class CaseTest extends TestCase
{
    public function testCase()
    {
        $neo4j = new Neo4j;

        $query = 'MATCH n RETURN n';

        $result = $neo4j->statement($query);

        dd($result->toArray());
    }
}
