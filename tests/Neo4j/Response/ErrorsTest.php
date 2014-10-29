<?php namespace EndyJasmi\Neo4j\Response;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ErrorsTest extends TestCase
{
    protected $errors = [
        [
            'code' => 'Neo.ClientError.Statement.InvalidSyntax',
            'message' => 'Invalid input \'T\': expected <init> (line 1, column 1)\n' .
                '"This is not a valid Cypher Statement."\n ^'
        ]
    ];

    /**
     * @expectedException EndyJasmi\Neo4j\Error\Neo\ClientError\Statement\InvalidSyntax
     */
    public function testConstructorMethod()
    {
        $errors = new Errors($this->errors);
    }
}
