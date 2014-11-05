<?php
/**
 * AbstractClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

/**
 * AbstractClause is a concrete implementation of abstractclause interface
 */
abstract class AbstractClause implements ClauseInterface
{
    /**
     * @var array Parameter array
     */
    protected $parameters = [];

    /**
     * @var object Parent instance
     */
    protected $parent;

    /**
     * Redirect to parent
     *
     * @param string $method Name string
     * @param array $parameters Parameter array
     *
     * @return mixed Return parent result
     */
    public function __call($method, array $parameters = [])
    {
        return call_user_func_array([$this->parent, $method], $parameters);
    }

    /**
     * Get parameter array
     *
     * @return array Return parameter array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    abstract public function getQuery();
}
