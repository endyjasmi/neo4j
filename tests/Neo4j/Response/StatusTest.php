<?php namespace EndyJasmi\Neo4j\Response;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class StatusTest extends TestCase
{
    protected $result;

    protected $status = [
        'constraints_added' => 0,
        'constraints_removed' => 0,
        'contains_updates' => false,
        'indexes_added' => 0,
        'indexes_removed' => 0,
        'labels_added' => 0,
        'labels_removed' => 0,
        'nodes_created' => 0,
        'nodes_deleted' => 0,
        'properties_set' => 0,
        'relationship_deleted' => 0,
        'relationships_created' => 0
    ];

    public function setUp()
    {
        $this->result = Mockery::mock('EndyJasmi\Neo4j\Response\ResultInterface');
    }

    public function testGetMagicMethod()
    {
        $status = new Status($this->result, $this->status);

        $this->assertFalse($status->containsUpdates);
        $this->assertEquals(0, $status->nodesCreated);
    }

    public function testGetResultMethod()
    {
        $status = new Status($this->result, $this->status);

        $result = $status->getResult();

        $this->assertSame($this->result, $result);
    }

    public function testSetResultMethod()
    {
        $status = new Status($this->result, $this->status);

        $return = $status->setResult($this->result);

        $this->assertSame($status, $return);
    }
}
