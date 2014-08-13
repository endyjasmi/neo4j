<?php namespace EndyJasmi\Neo4j\Facades;

use Illuminate\Support\Facades\Facade;

class Neo4j extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'neo4j';
    }
}
