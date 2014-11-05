<?php
/**
 * StreamDriver class file
 *
 * @package EndyJasmi\Neo4j\Driver;
 */
namespace EndyJasmi\Neo4j\Driver;

use Buzz\Client\ClientInterface;
use Buzz\Client\FileGetContents as Client;
use Buzz\Message\Request;
use Buzz\Message\Response;
use EndyJasmi\Neo4j\DriverInterface;

/**
 * StreamDriver is a concrete implementation of driver interface
 */
class StreamDriver extends CurlDriver implements DriverInterface
{
    /**
     * Send request
     *
     * This method is used internally only, it is made public for partial mocking purposes
     *
     * @param Request $request Request instance
     * @param Client $client Client instance
     * @param Response $response Response instance
     *
     * @return array Return response array
     */
    public function send(Request $request, ClientInterface $client = null, Response $response = null)
    {
        $client = $client ?: new Client;

        return parent::send($request, $client, $response);
    }
}
