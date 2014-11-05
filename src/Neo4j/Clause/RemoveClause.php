<?php
/**
 * RemoveClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use EndyJasmi\Neo4j\QueryInterface;

/**
 * RemoveClause is a concrete implementation of clause interface
 */
class RemoveClause extends AbstractClause
{
    /**
     * @var array Pattern array
     */
    protected $patterns = [];

    /**
     * Remove clause constructor
     *
     * @param QueryInterface $parent Parent instance
     * @param string $pattern Pattern string
     */
    public function __construct(QueryInterface $parent, $pattern)
    {
        $this->remove($pattern)
            ->parent = $parent;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        $patterns = implode(', ', $this->patterns);

        return "REMOVE $patterns";
    }

    /**
     * Remove pattern
     *
     * @param string $pattern Pattern string
     *
     * @return ClauseInterface Return self
     */
    public function remove($pattern)
    {
        $this->patterns[] = $pattern;

        return $this;
    }
}
