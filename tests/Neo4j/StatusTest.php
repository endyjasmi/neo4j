<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class StatusTest extends TestCase
{
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

    public function testGetMagicMethod()
    {
        // Given
        $status = new Status($this->status);

        // When
        $updates = $status->containsUpdates;

        // Expect
        $this->assertFalse($updates);
    }
}
