<?php
/**
 * CreateClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use EndyJasmi\Neo4j\QueryInterface;

/**
 * CreateClause is a concrete implementation of clause interface
 */
class CreateClause extends AbstractClause
{
    /**
     * @var array Pattern array
     */
    protected $patterns = [];

    /**
     * Create clause constructor
     *
     * @param QueryInterface $parent Parent instance
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     */
    public function __construct(QueryInterface $parent, $pattern, array $parameters = [])
    {
        $this->create($pattern, $parameters)
            ->parent = $parent;
    }

    /**
     * Create pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return self
     */
    public function create($pattern, array $parameters = [])
    {
        $this->patterns[] = $pattern;
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        $patterns = implode(', ', $this->patterns);

        return "CREATE $patterns";
    }
}
