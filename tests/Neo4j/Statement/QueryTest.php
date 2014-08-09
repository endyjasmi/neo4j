<?php namespace EndyJasmi\Neo4j\Statement;

use PHPUnit_Framework_TestCase as TestCase;

class QueryTest extends TestCase
{
    public function testParameter()
    {
        $query = 'match (n) where n.name = ? and n.age = ? return n';
        $statement = new Query($query);

        $this->assertEquals(
            'match (n) where n.name = {parameter_0} and n.age = {parameter_1} return n',
            (string) $statement
        );
    }

    public function testMixedParameter()
    {
        $query = 'match (n) where n.name = ? and n.age = {age} return n';
        $statement = new Query($query);

        $this->assertEquals(
            'match (n) where n.name = {parameter_0} and n.age = {age} return n',
            (string) $statement
        );
    }
}
