<?php
/**
 * SetClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use EndyJasmi\Neo4j\QueryInterface;

/**
 * SetClause is a concrete implementation of clause interface
 */
class SetClause extends AbstractClause
{
    /**
     * @var array Pattern array
     */
    protected $patterns = [];

    /**
     * Set clause constructor
     *
     * @param QueryInterface $parent Parent instance
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     */
    public function __construct(QueryInterface $parent, $pattern, array $parameters = [])
    {
        $this->set($pattern, $parameters)
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

        return "SET $patterns";
    }

    /**
     * Set target value
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return self
     */
    public function set($pattern, array $parameters = [])
    {
        $this->patterns[] = $pattern;
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }
}
