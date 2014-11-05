<?php
/**
 * Clause interface file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

/**
 * ClauseInterface is an interface for clause class
 */
interface ClauseInterface
{
    /**
     * Get parameter array
     *
     * @return array Return parameter array
     */
    public function getParameters();

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery();
}
