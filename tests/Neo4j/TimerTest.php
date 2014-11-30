<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class TimerTest extends TestCase
{
    public function testGetTimeMethod()
    {
        // Given
        $timer = new Timer;

        // When
        $time = $timer->getTime();

        // Expect
        $this->assertNull($time);
    }

    public function testRestartMethod()
    {
        // Given
        $timer = new Timer;

        // When
        $self = $timer->restart();

        // Expect
        $this->assertSame($timer, $self);
    }

    public function testStartMethod()
    {
        // Given
        $timer = new Timer;

        // When
        $self = $timer->start();

        // Expect
        $this->assertSame($timer, $self);
    }

    public function testStopMethod()
    {
        // Given
        $timer = new Timer;

        $timer->start();

        // When
        $self = $timer->stop();

        // Expect
        $this->assertSame($timer, $self);
    }
}
