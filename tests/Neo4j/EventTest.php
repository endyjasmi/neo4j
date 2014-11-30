<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class EventTest extends TestCase
{
    public function setUp()
    {
        $this->dispatcher = Mockery::mock('Illuminate\Events\Dispatcher');
    }

    public function testGetDispatcher()
    {
        // Given
        $event = new Event($this->dispatcher);

        // When
        $dispatcher = $event->getDispatcher();

        // Expect
        $this->assertSame($this->dispatcher, $dispatcher);
    }

    public function testFireMethod()
    {
        // Given
        $event = new Event($this->dispatcher);

        $this->dispatcher->shouldReceive('fire')
            ->once();

        $query = 'MATCH n RETURN n';
        $parameters = [];
        $time = microtime(true);

        // When
        $self = $event->fire($query, $parameters, $time);

        // Expect
        $this->assertSame($event, $self);
    }

    public function testListenMethod()
    {
        // Given
        $event = new Event($this->dispatcher);

        $this->dispatcher->shouldReceive('listen')
            ->once();

        $listener = function ($query, array $parameters, $time) {
        };

        // When
        $self = $event->listen($listener);

        // Expect
        $this->assertSame($event, $self);
    }

    public function testSetDispatcherMethod()
    {
        // Given
        $event = new Event($this->dispatcher);

        // When
        $self = $event->setDispatcher($this->dispatcher);

        // Expect
        $this->assertSame($event, $self);
    }
}
