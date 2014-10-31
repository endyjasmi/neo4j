<?php
/**
 * Neo4j class file
 *
 * @package EndyJasmi\Neo4j\Laravel;
 */
namespace EndyJasmi\Neo4j\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * Neo4j is a laravel facade
 */
class Neo4j extends Facade
{
    /**
     * Get the registered name of the component
     *
     * @return string Return component name string
     */
    protected static function getFacadeAccessor()
    {
        return 'neo4j';
    }
}
