<?php
/**
 * Query class file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Clause\ClauseInterface;
use EndyJasmi\Neo4j\Clause\CreateClause;
use EndyJasmi\Neo4j\Clause\CreateUniqueClause;
use EndyJasmi\Neo4j\Clause\DeleteClause;
use EndyJasmi\Neo4j\Clause\MatchClause;
use EndyJasmi\Neo4j\Clause\MergeClause;
use EndyJasmi\Neo4j\Clause\OnCreateClause;
use EndyJasmi\Neo4j\Clause\OnMatchClause;
use EndyJasmi\Neo4j\Clause\OptionalMatchClause;
use EndyJasmi\Neo4j\Clause\OutputClause;
use EndyJasmi\Neo4j\Clause\RemoveClause;
use EndyJasmi\Neo4j\Clause\SetClause;
use EndyJasmi\Neo4j\Clause\WithClause;

/**
 * Query is a concrete implementation of query interface
 */
class Query implements QueryInterface
{
    /**
     * @var array Clause array
     */
    protected $clauses = [];

    /**
     * @var ConnectionInterface Connection instance
     */
    protected $connection;

    /**
     * Query constructor
     *
     * @param ConnectionInterface|ResponseInterface $connection Connection instance
     */
    public function __construct($connection)
    {
        $this->setConnection($connection);
    }

    /**
     * Create pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return create instance
     */
    public function create($pattern, array $parameters = [])
    {
        return $this->clauses[] = new CreateClause($this, $pattern, $parameters);
    }

    /**
     * Create unique pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return create instance
     */
    public function createUnique($pattern, array $parameters = [])
    {
        return $this->clauses[] = new CreateUniqueClause($this, $pattern, $parameters);
    }

    /**
     * Delete pattern
     *
     * @param string $pattern Pattern string
     *
     * @return DeleteInterface Return delete instance
     */
    public function delete($pattern)
    {
        return $this->clauses[] = new DeleteClause($this, $pattern);
    }

    /**
     * Get first result
     *
     * @return mixed|null Return first row or null
     */
    public function first()
    {
        $result = $this->run();

        return $result[0];
    }

    /**
     * Commit query
     *
     * @return ResultInterface Return result instance
     */
    public function get()
    {
        return $this->run();
    }

    /**
     * Get connection instance
     *
     * @return ConnectionInterface Return connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Match pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return match instance
     */
    public function match($pattern, array $parameters = [])
    {
        return $this->clauses[] = new MatchClause($this, $pattern, $parameters);
    }

    /**
     * Merge pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return merge instance
     */
    public function merge($pattern, array $parameters = [])
    {
        return $this->clauses[] = new MergeClause($this, $pattern, $parameters);
    }

    /**
     * Merge on create
     *
     * @return ClauseInterface Return on create instance
     */
    public function onCreate()
    {
        return $this->clauses[] = new OnCreateClause($this);
    }

    /**
     * Merge on match
     *
     * @return ClauseInterface Return on match instance
     */
    public function onMatch()
    {
        return $this->clauses[] = new OnMatchClause($this);
    }

    /**
     * Optional match pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return match instance
     */
    public function optionalMatch($pattern, array $parameters = [])
    {
        return $this->clauses[] = new OptionalMatchClause($this, $pattern, $parameters);
    }

    /**
     * Output field
     *
     * @param string $field Name string
     * @param string $alias Alias string
     */
    public function output($field, $alias = null)
    {
        return $this->clauses[] = new OutputClause($this, $field, $alias);
    }

    /**
     * Generate parameter array
     *
     * @return array Return parameter array
     */
    public function parameters()
    {
        $parameters = [];

        foreach ($this->clauses as $clause) {
            $parameters = array_merge($parameters, $clause->getParameters());
        }

        return $parameters;
    }

    /**
     * Remove pattern
     *
     * @param string $pattern Pattern string
     *
     * @return ClauseInterface Return remove instance
     */
    public function remove($pattern)
    {
        return $this->clauses[] = new RemoveClause($this, $pattern);
    }

    /**
     * Run query
     *
     * @return ResultInterface Return result instance
     */
    public function run()
    {
        return $this->getConnection()
            ->statement($this->string(), $this->parameters());
    }

    /**
     * Set pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return set instance
     */
    public function set($pattern, array $parameters = [])
    {
        return $this->clauses[] = new SetClause($this, $pattern, $parameters);
    }

    /**
     * Set connection instance
     *
     * @param ConnectionInterface|ResponseInterface $connection Connection instance
     *
     * @return QueryInterface Return self
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Generate query string
     *
     * @return string Return query string
     */
    public function string()
    {
        $queries = array_map(
            function (ClauseInterface $clause) {
                return $clause->getQuery();
            },
            $this->clauses
        );

        return implode(' ', $queries);
    }

    /**
     * With field
     *
     * @param string $field Name string
     * @param string $alias Alias string
     *
     * @return ClauseInterface Return with instance
     */
    public function with($field, $alias = null)
    {
        return $this->clauses[] = new WithClause($this, $field, $alias);
    }
}
