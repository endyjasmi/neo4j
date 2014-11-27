<?php namespace EndyJasmi\Neo4j\Driver;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class CurlDriverTest extends TestCase
{
    public function testCreateClientMethod()
    {
        // Given
        $driver = new CurlDriver;

        // When
        $client = $driver->createClient();

        // Expect
        $this->assertInstanceOf('Buzz\Client\ClientInterface', $client);
    }
}
