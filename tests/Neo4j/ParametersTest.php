<?php namespace EndyJasmi\Neo4j\Statement;

use PHPUnit_Framework_TestCase as TestCase;

class ParametersTest extends TestCase
{
    public function testUnamedParameters()
    {
        $parameters = array('Endy Jasmi', '24');
        $parameters = new Parameters($parameters);
        $parameters = $parameters->toArray();

        $this->assertArrayHasKey('parameter_0', $parameters);
        $this->assertArrayHasKey('parameter_1', $parameters);
    }

    public function testNamedParameters()
    {
        $parameters = array(
            'name' => 'Endy Jasmi',
            'age' => 24
        );
        $parameters = new Parameters($parameters);
        $parameters = $parameters->toArray();

        $this->assertArrayHasKey('name', $parameters);
        $this->assertArrayHasKey('age', $parameters);
    }

    public function testMixedParameters()
    {
        $parameters = array('Endy Jasmi', 'age' => 24);
        $parameters = new Parameters($parameters);
        $parameters = $parameters->toArray();

        $this->assertArrayHasKey('parameter_0', $parameters);
        $this->assertArrayHasKey('age', $parameters);
    }
}
