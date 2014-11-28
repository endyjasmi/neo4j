<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax;
use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ErrorTest extends TestCase
{
    public function setUp()
    {
        $this->factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');

        $this->errors = [
            [
                'code' => 'Neo.ClientError.Statement.InvalidSyntax',
                'message' => "Invalid input 'T': expected <init>" ." (line 1, column 1)\n\"" .
                    "This is not a valid Cypher Statement.\"\n ^"
            ]
        ];
    }

    /**
     * @expectedException EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax
     */
    public function testErrorAutoThrow()
    {
        // Given
        $exception = new InvalidSyntax;
        $this->factory->shouldReceive('createException')
            ->once()
            ->andReturn($exception);

        $error = new Error($this->factory, $this->errors);
    }
}
