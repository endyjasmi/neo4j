<?php namespace EndyJasmi\Neo4j\Result;

use PHPUnit_Framework_TestCase as TestCase;

class StatusTest extends TestCase
{
    public function testStatus()
    {
        $status = new Status(
            array(
                'constraints_added' => 0,
                'contains_updates' => true
            )
        );

        $this->assertEquals(0, $status->constraintsAdded);
        $this->assertEquals(true, $status->containsUpdates);
    }
}
