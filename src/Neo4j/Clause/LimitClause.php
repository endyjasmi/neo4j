<?php
/**
 * LimitClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

/**
 * LimitClause is a concrete implementation of clause interface
 */
class LimitClause extends AbstractClause
{
    /**
     * @var string Alias string
     */
    protected $alias;

    /**
     * Limit clause constructor
     *
     * @param ClauseInterface $parent Parent instance
     * @param integer $limit Limit number
     * @param string $alias Alias string
     */
    public function __construct(ClauseInterface $parent, $limit, $alias = 'limit')
    {
        $this->parent = $parent;
        $this->alias = $alias;

        $this->parameters[$this->alias] = $limit;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        return "LIMIT {{$this->alias}}";
    }
}
