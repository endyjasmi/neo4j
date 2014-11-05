<?php
/**
 * Errors class file
 *
 * @package EndyJasmi\Neo4j\Response;
 */
namespace EndyJasmi\Neo4j\Response;

use Exception;
use Illuminate\Support\Collection;

/**
 * Errors is a concrete implementation of errors interface
 */
class Errors extends Collection implements ErrorsInterface
{
    /**
     * Create exception object
     */
    protected function exception(array $error)
    {
        $class = 'EndyJasmi\\Neo4j\\Error\\';
        $class .= str_replace('.', '\\', $error['code']);

        return new $class($error['message'], $error['code']);
    }

    /**
     * Errors constructor
     *
     * @param array $errors Raw errors
     * @param boolean $throws Auto throws exception
     */
    public function __construct(array $errors, $throws = true)
    {
        foreach ($errors as $error) {
            $this->push(static::exception($error));
        }

        if ($throws && count($this) > 0) {
            throw $this[0];
        }
    }

    /**
     * Convery errors to array
     *
     * @return array Return errors array
     */
    public function toArray()
    {
        return array_map(
            function (Exception $error) {
                return [
                    'code' => $error->getCode(),
                    'message' => $error->getMessage()
                ];
            },
            parent::toArray()
        );
    }
}
