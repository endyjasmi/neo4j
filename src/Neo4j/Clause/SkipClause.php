<?php
/**
 * SkipClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

/**
 * SkipClause is a concrete implementation of clause interface
 */
class SkipClause extends AbstractClause
{
    /**
     * @var string Alias string
     */
    protected $alias;

    /**
     * SkipClause constructor
     *
     * @param ClauseInterface $parent Parent instance
     * @param integer $skip Skip number
     * @param string $alias Alias string
     */
    public function __construct(ClauseInterface $parent, $skip, $alias = 'skip')
    {
        $this->parent = $parent;
        $this->alias = $alias;

        $this->parameters[$this->alias] = $skip;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        return "SKIP {{$this->alias}}";
    }
}
