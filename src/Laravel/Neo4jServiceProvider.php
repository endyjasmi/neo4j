<?php
/**
 * Neo4jServiceProvider class file
 *
 * @package EndyJasmi\Neo4j\Laravel;
 */
namespace EndyJasmi\Laravel;

use EndyJasmi\Neo4j;
use Illuminate\Support\ServiceProvider;

/**
 * Neo4jServiceProvider is a concrete implementation of service provider interface
 */
class Neo4jServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Post registration hook
     */
    public function boot()
    {
        $this->app->bindShared(
            'neo4j',
            function ($app) {
                return new Neo4j(null, $app);
            }
        );
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('EndyJasmi\Neo4j\ConnectionInterface', 'EndyJasmi\Neo4j\Connection');
        $this->bind('EndyJasmi\Neo4j\QueryInterface', 'EndyJasmi\Neo4j\Query');
        $this->app->bind('EndyJasmi\Neo4j\RequestInterface', 'EndyJasmi\Neo4j\Request');
        $this->app->bind('EndyJasmi\Neo4j\Request\StatementInterface', 'EndyJasmi\Neo4j\Request\Statement');
        $this->app->bind('EndyJasmi\Neo4j\ResponseInterface', 'EndyJasmi\Neo4j\Response');
        $this->app->bind('EndyJasmi\Neo4j\Response\ErrorsInterface', 'EndyJasmi\Neo4j\Response\Errors');
        $this->app->bind('EndyJasmi\Neo4j\Response\ResultInterface', 'EndyJasmi\Neo4j\Response\Result');
        $this->app->bind('EndyJasmi\Neo4j\Response\StatusInterface', 'EndyJasmi\Neo4j\Response\Status');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'EndyJasmi\Neo4j\ConnectionInterface',
            'EndyJasmi\Neo4j\QueryInterface',
            'EndyJasmi\Neo4j\RequestInterface',
            'EndyJasmi\Neo4j\Request\StatementInterface',
            'EndyJasmi\Neo4j\ResponseInterface',
            'EndyJasmi\Neo4j\Response\ErrorsInterface',
            'EndyJasmi\Neo4j\Response\ResultInterface',
            'EndyJasmi\Neo4j\Response\StatusInterface',
            'neo4j'
        ];
    }
}
