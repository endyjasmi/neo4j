<?php
/**
 * OnMatchClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use EndyJasmi\Neo4j\QueryInterface;

/**
 * OnMatchClause is a concrete implementation of clause interface
 */
class OnMatchClause extends AbstractClause
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
        return "ON MATCH";
    }
}
