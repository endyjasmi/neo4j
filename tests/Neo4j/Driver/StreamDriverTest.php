<?php namespace EndyJasmi\Neo4j\Driver;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class StreamDriverTest extends TestCase
{
    public function testCreateClientMethod()
    {
        // Given
        $driver = new StreamDriver;

        // When
        $client = $driver->createClient();

        // Expect
        $this->assertInstanceOf('Buzz\Client\ClientInterface', $client);
    }
}
