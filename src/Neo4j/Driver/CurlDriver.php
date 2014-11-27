<?php namespace EndyJasmi\Neo4j\Driver;

use Buzz\Client\Curl;

class CurlDriver extends AbstractDriver
{
    /**
     * Create client instance
     *
     * @return ClientInterface
     */
    public function createClient()
    {
        return new Curl;
    }
}
