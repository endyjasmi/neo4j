<?php
/**
 * Registry class file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use Illuminate\Container\Container as IlluminateContainer;

/**
 * Registry is an alias for illuminate container
 */
class Container extends IlluminateContainer
{
    /**
     * Registry constructor
     */
    public function __construct($configPath = null)
    {
        // Basic binding
        $this->bind('EndyJasmi\Neo4j\ConnectionInterface', 'EndyJasmi\Neo4j\Connection');
        $this->bind('EndyJasmi\Neo4j\QueryInterface', 'EndyJasmi\Neo4j\Query');
        $this->bind('EndyJasmi\Neo4j\RequestInterface', 'EndyJasmi\Neo4j\Request');
        $this->bind('EndyJasmi\Neo4j\Request\StatementInterface', 'EndyJasmi\Neo4j\Request\Statement');
        $this->bind('EndyJasmi\Neo4j\ResponseInterface', 'EndyJasmi\Neo4j\Response');
        $this->bind('EndyJasmi\Neo4j\Response\ErrorsInterface', 'EndyJasmi\Neo4j\Response\Errors');
        $this->bind('EndyJasmi\Neo4j\Response\ResultInterface', 'EndyJasmi\Neo4j\Response\Result');
        $this->bind('EndyJasmi\Neo4j\Response\StatusInterface', 'EndyJasmi\Neo4j\Response\Status');

        // Setup config component
        $configPath = $configPath ?: dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config';

        $this->bindShared(
            'Illuminate\Config\LoaderInterface',
            function (Container $registry) use ($configPath) {
                return $registry->make(
                    'Illuminate\Config\FileLoader',
                    [
                        'defaultPath' =>  $configPath
                    ]
                );
            }
        );

        $this->bindShared(
            'config',
            function (Container $container) {
                return $container->make(
                    'Illuminate\Config\Repository',
                    [
                        'environment' => 'production'
                    ]
                );
            }
        );

        // Setup event component
        $this->bind('Illuminate\Contracts\Events\Dispatcher', 'Illuminate\Events\Dispatcher');
        
        $this->bindShared(
            'events',
            function (Container $container) {
                return $container->make(
                    'Illuminate\Contracts\Events\Dispatcher',
                    [
                        'container' => $container
                    ]
                );
            }
        );
    }
}
