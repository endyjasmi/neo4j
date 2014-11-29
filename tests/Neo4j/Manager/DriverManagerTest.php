<?php namespace EndyJasmi\Neo4j\Manager;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class DriverManagerTest extends TestCase
{
    public function testGetDriverMethod()
    {
        // Given
        $manager = new DriverManagerStub;

        // When
        $driver = $manager->getDriver();

        // Expect
        $this->assertNull($driver);
    }

    public function testSetDriverMethod()
    {
        // Given
        $manager = new DriverManagerStub;

        $driver = Mockery::mock('EndyJasmi\Neo4j\DriverInterface');

        // When
        $self = $manager->setDriver($driver);

        // Expect
        $this->assertSame($manager, $self);
    }
}
