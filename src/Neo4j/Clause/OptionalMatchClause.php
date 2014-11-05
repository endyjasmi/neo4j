<?php
/**
 * OptionalMatchClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use BadMethodCallException;
use EndyJasmi\Neo4j\QueryInterface;

/**
 * OptionalMatchClause is a concrete implementation of clause interface
 */
class OptionalMatchClause extends MatchClause
{
    /**
     * Match clause constructor
     *
     * @param QueryInterface $parent Parent instance
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     */
    public function __construct(QueryInterface $parent, $pattern, array $parameters = [])
    {
        $this->optionalMatch($pattern, $parameters)
            ->parent = $parent;
    }

    /**
     * Match pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return self
     *
     * @throws BadMethodCallException If called
     */
    public function match($pattern, array $parameters = [])
    {
        throw new BadMethodCallException("Cannot call this method");
    }

    /**
     * Match pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return self
     */
    public function optionalMatch($pattern, array $parameters = [])
    {
        return parent::match($pattern, $parameters);
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        $query = parent::getQuery();

        return "OPTIONAL $query";
    }
}
