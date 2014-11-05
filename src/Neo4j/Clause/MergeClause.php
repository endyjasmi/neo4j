<?php
/**
 * MergeClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use EndyJasmi\Neo4j\QueryInterface;

/**
 * MergeClause is a concrete implementation of clause interface
 */
class MergeClause extends AbstractClause
{
    /**
     * @var string Pattern string
     */
    protected $pattern;

    /**
     * Merge clause constructor
     *
     * @param QueryInterface $parent Parent instance
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     */
    public function __construct(QueryInterface $parent, $pattern, array $parameters = [])
    {
        $this->parent = $parent;
        $this->pattern = $pattern;
        $this->parameters = $parameters;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        return "MERGE {$this->pattern}";
    }
}
