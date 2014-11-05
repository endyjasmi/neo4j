<?php
/**
 * DeleteClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use EndyJasmi\Neo4j\QueryInterface;

/**
 * DeleteClause is a concrete implementation of clause interface
 */
class DeleteClause extends AbstractClause
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
        $this->delete($pattern)
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

        return "DELETE $patterns";
    }

    /**
     * Remove pattern
     *
     * @param string $pattern Pattern string
     *
     * @return ClauseInterface Return self
     */
    public function delete($pattern)
    {
        $this->patterns[] = $pattern;

        return $this;
    }
}
