<?php
/**
 * Registry class file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use Illuminate\Container\Container;

/**
 * Registry is a concrete implementation of registry interface
 */
class Registry extends Container
{
    /**
     * Registry constructor
     */
    public function __construct()
    {
        // Basic binding
        $this->bind('EndyJasmi\Neo4j\ConnectionInterface', 'EndyJasmi\Neo4j\Connection');
        $this->bind('EndyJasmi\Neo4j\RequestInterface', 'EndyJasmi\Neo4j\Request');
        $this->bind('EndyJasmi\Neo4j\Request\StatementInterface', 'EndyJasmi\Neo4j\Request\Statement');
        $this->bind('EndyJasmi\Neo4j\ResponseInterface', 'EndyJasmi\Neo4j\Response');
        $this->bind('EndyJasmi\Neo4j\Response\ErrorsInterface', 'EndyJasmi\Neo4j\Response\Errors');
        $this->bind('EndyJasmi\Neo4j\Response\ResultInterface', 'EndyJasmi\Neo4j\Response\Result');
        $this->bind('EndyJasmi\Neo4j\Response\StatusInterface', 'EndyJasmi\Neo4j\Response\Status');
        
        // Setup config component
        $this->bindShared(
            'Illuminate\Config\LoaderInterface',
            function ($registry) {
                return $registry->make(
                    'Illuminate\Config\FileLoader',
                    [
                        'defaultPath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config';
                    ]
                );
            }
        );

        $this->bindShared(
            'config',
            function ($registry) {
                return $registry->make(
                    'Illuminate\Config\Repository',
                    [
                        'environment' => 'production'
                    ]
                );
            }
        );
    }
}
