<?php namespace EndyJasmi\Neo4j;

interface StatusInterface extends CollectionInterface
{
    /**
     * Status constructor
     *
     * @param array $status
     */
    public function __construct(array $status);
}
