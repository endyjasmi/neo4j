<?php
/**
 * MatchClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use EndyJasmi\Neo4j\QueryInterface;

/**
 * MatchClause is a concrete implementation of clause interface
 */
class MatchClause extends AbstractClause
{
    /**
     * @var array Pattern array
     */
    protected $patterns = [];

    /**
     * @var ClauseInterface Using instance
     */
    protected $using;

    /**
     * @var ClauseInterface Where instance
     */
    protected $where;

    /**
     * Match clause constructor
     *
     * @param QueryInterface $parent Parent instance
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     */
    public function __construct(QueryInterface $parent, $pattern, array $parameters = [])
    {
        $this->match($pattern, $parameters)
            ->parent = $parent;
    }

    /**
     * Get parameter array
     *
     * @return array Return parameter
     */
    public function getParameters()
    {
        $parameters = $this->parameters;

        if (! is_null($this->where)) {
            $parameters = array_merge($parameters, $this->where->getParameters());
        }

        return $parameters;
    }

    /**
     * Get query string
     *
     * @return string Return query
     */
    public function getQuery()
    {
        $patterns = implode(', ', $this->patterns);
        $match = "MATCH $patterns";

        if (! is_null($this->using)) {
            $using = $this->using
                ->getQuery();

            $match = "$match $using";
        }

        if (! is_null($this->where)) {
            $where = $this->where
                ->getQuery();

            $match = "$match $where";
        }

        return $match;
    }

    /**
     * Match pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return self
     */
    public function match($pattern, array $parameters = [])
    {
        $this->patterns[] = $pattern;
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }

    /**
     * Using index
     *
     * @param string $index Index string
     *
     * @return ClauseInterface Return self
     */
    public function usingIndex($index)
    {
        if (is_null($this->using)) {
            $this->using = new UsingClause($this, UsingClause::INDEX, $index);
        } else {
            $this->using->usingIndex($index);
        }

        return $this->using;
    }

    /**
     * Using scan
     *
     * @param string $index Index string
     *
     * @return ClauseInterface Return self
     */
    public function usingScan($index)
    {
        if (is_null($this->using)) {
            $this->using = new UsingClause($this, UsingClause::SCAN, $index);
        } else {
            $this->using->usingIndex($index);
        }

        return $this->using;
    }

    /**
     * Where condition
     *
     * @param string $condition Condition string
     * @param array $parameters Parameter array
     *
     * @return  ClauseInterface Return where instance
     */
    public function where($condition, array $parameters = [])
    {
        return $this->where = new WhereClause($this, $condition, $parameters);
    }
}
