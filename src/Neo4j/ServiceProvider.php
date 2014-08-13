<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider
{
    protected $defer = false;

    public function boot()
    {
        $this->package('endyjasmi/neo4j');

        $this->app->singleton('neo4j', function ($app) {
            $config = $app['config']->get('neo4j');

            return new Neo4j($config);
        });
    }

    public function register()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Neo4j', 'EndyJasmi\Neo4j\Facades\Neo4j');
        });
    }

    public function provides()
    {
        return array('neo4j');
    }
}
