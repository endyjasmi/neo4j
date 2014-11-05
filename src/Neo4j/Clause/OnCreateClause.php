<?php
/**
 * OnCreateClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use EndyJasmi\Neo4j\QueryInterface;

/**
 * OnCreateClause is a concrete implementation of clause interface
 */
class OnCreateClause extends AbstractClause
{
    /**
     * On create constructor
     *
     * @param QueryInterface $parent Parent instance
     */
    public function __construct(QueryInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        return "ON CREATE";
    }
}
