<?php namespace EndyJasmi\Neo4j\Manager;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class EventManagerTest extends TestCase
{
    public function testGetEventMethod()
    {
        // Given
        $manager = new EventManagerStub;

        // When
        $event = $manager->getEvent();

        // Expect
        $this->assertNull($event);
    }

    public function testSetEventMethod()
    {
        // Given
        $manager = new EventManagerStub;

        $event = Mockery::mock('EndyJasmi\Neo4j\EventInterface');

        // When
        $self = $manager->setEvent($event);

        // Expect
        $this->assertSame($manager, $self);
    }
}
