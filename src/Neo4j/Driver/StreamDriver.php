<?php namespace EndyJasmi\Neo4j\Driver;

use Buzz\Client\FileGetContents;

class StreamDriver extends AbstractDriver
{
    /**
     * Create client instance
     *
     * @return ClientInterface
     */
    public function createClient()
    {
        return new FileGetContents;
    }
}
