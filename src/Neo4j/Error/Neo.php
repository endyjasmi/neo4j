<?php 
/**
 * Neo4j exception file
 *
 * @package EndyJasmi\Neo4j\Error
 */
namespace EndyJasmi\Neo4j\Error;

use \Exception;

/**
 * Neo is an exception class which represent the error status code returned by the server
 */
class Neo extends Exception
{
    /**
     * Error constructor
     *
     * @param string $message Message string
     * @param string $code Code string
     */
    public function __construct($message, $code)
    {
        parent::__construct($message);

        $this->code = $code;
    }
}
