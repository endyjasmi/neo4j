<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class RequestTest extends TestCase
{
    protected $statement;

    public function setUp()
    {
        $this->statement = Mockery::mock('EndyJasmi\Neo4j\Statement');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testAddStatement()
    {
        $request = new Request;

        $return = $request->addStatement($this->statement);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Request', $request);
    }

    public function testToArray()
    {
        $this->statement->shouldReceive('toArray')
            ->times(2)
            ->andReturn(array());

        $request = new Request;

        $request = $request->addStatement($this->statement)
            ->addStatement($this->statement)
            ->toArray();

        $this->assertCount(2, $request);
    }

    public function testToJson()
    {
        $this->statement->shouldReceive('toArray')
            ->times(2)
            ->andReturn(
                array(
                    'statement' => 'query'
                )
            );

        $request = new Request;

        $request = $request->addStatement($this->statement)
            ->addStatement($this->statement)
            ->toJson();

        $this->assertEquals(
            '[{"statement":"query"},{"statement":"query"}]',
            $request
        );
    }
}
