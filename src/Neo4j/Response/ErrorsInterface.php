<?php
/**
 * Errors interface file
 *
 * @package EndyJasmi\Neo4j\Response;
 */
namespace EndyJasmi\Neo4j\Response;

/**
 * ErrorsInterface is an interface for errors class
 */
interface ErrorsInterface
{
    /**
     * Errors constructor
     *
     * @param array $errors Raw errors
     * @param boolean $throws Auto throws exception
     */
    public function __construct(array $errors, $throws = true);
}
