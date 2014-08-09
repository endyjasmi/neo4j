<?php namespace EndyJasmi\Neo4j;

use PHPUnit_Framework_TestCase as TestCase;

class ErrorTest extends TestCase
{
    protected $error = array(
        'code' => 'Test.Error',
        'message' => 'Test error'
    );

    public function testGetCode()
    {
        $error = new Error($this->error);
        $code = $error->getCode();

        $this->assertEquals('Test.Error', $code);
    }

    public function testGetMessage()
    {
        $error = new Error($this->error);
        $message = $error->getMessage();

        $this->assertEquals('Test error', $message);
    }
}
