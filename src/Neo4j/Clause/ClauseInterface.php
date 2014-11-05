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
     * Redirect to parent
     *
     * @param string $method Name string
     * @param array $parameters Parameter array
     *
     * @return mixed Return parent result
     */
    public function __call($method, array $parameters = []);
    
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
