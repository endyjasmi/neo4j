<?php
/**
 * WhereClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

/**
 * WhereClause is a concrete implementation of clause interface
 */
class WhereClause extends AbstractClause
{
    /**
     * @var string Condition string
     */
    protected $condition;

    /**
     * WhereClause constructor
     *
     * @param ClauseInterface $parent Parent instance
     * @param string $condition Condition string
     * @param array $parameters Parameter array
     */
    public function __construct(ClauseInterface $parent, $condition, array $parameters = [])
    {
        $this->parent = $parent;
        $this->condition = $condition;
        $this->parameters = $parameters;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        return "WHERE {$this->condition}";
    }
}
