<?php
/**
 * Errors interface file
 *
 * @package EndyJasmi\Neo4j\Response;
 */
namespace EndyJasmi\Neo4j\Response;

/**
 * ErrorsInterface is an interface for errors class
 * @todo Extend collection
 */
interface ErrorsInterface
{
    /**
     * Errors constructor
     *
     * @param array $items Raw errors
     */
    public function __construct($items = []);

    /**
     * Throw first error
     *
     * @throws Neo If there is error in the list
     */
    public function throws();
}
