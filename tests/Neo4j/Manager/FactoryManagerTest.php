<?php namespace EndyJasmi\Neo4j\Manager;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class FactoryManagerTest extends TestCase
{
    public function testGetFactoryMethod()
    {
        // Given
        $manager = new FactoryManagerStub;

        // When
        $factory = $manager->getFactory();

        // Expect
        $this->assertNull($factory);
    }

    public function testSetFactoryMethod()
    {
        // Given
        $manager = new FactoryManagerStub;

        $factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');

        // When
        $self = $manager->setFactory($factory);

        // Expect
        $this->assertSame($manager, $self);
    }
}
