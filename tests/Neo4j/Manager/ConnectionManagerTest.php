<?php namespace EndyJasmi\Neo4j\Manager;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class ConnectionManagerTest extends TestCase
{
    public function testGetConnectionMethod()
    {
        // Given
        $manager = new ConnectionManagerStub;

        // When
        $connection = $manager->getConnection();

        // Expect
        $this->assertNull($connection);
    }

    public function testSetConnectionMethod()
    {
        // Given
        $manager = new ConnectionManagerStub;

        $connection = Mockery::mock('EndyJasmi\Neo4j\ConnectionInterface');

        // When
        $self = $manager->setConnection($connection);

        // Expect
        $this->assertSame($manager, $self);
    }
}
