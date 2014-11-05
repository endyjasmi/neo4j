<?php
/**
 * Query interface file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Clause\ClauseInterface;
use EndyJasmi\Neo4j\Response\ResultInterface;

/**
 * QueryInterface is an interface for query class
 */
interface QueryInterface
{
    /**
     * Query constructor
     *
     * @param ConnectionInterface|ResponseInterface $connection Connection instance
     */
    public function __construct($connection);

    /**
     * Create pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return create instance
     */
    public function create($pattern, array $parameters = []);

    /**
     * Create unique pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return create instance
     */
    public function createUnique($pattern, array $parameters = []);

    /**
     * Delete pattern
     *
     * @param string $pattern Pattern string
     *
     * @return DeleteInterface Return delete instance
     */
    public function delete($pattern);

    /**
     * Get first result
     *
     * @return mixed|null Return first row or null
     */
    public function first();

    /**
     * Commit query
     *
     * @return ResultInterface Return result instance
     */
    public function get();

    /**
     * Get connection instance
     *
     * @return ConnectionInterface Return connection instance
     */
    public function getConnection();

    /**
     * Match pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return match instance
     */
    public function match($pattern, array $parameters = []);

    /**
     * Merge pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return merge instance
     */
    public function merge($pattern, array $parameters = []);

    /**
     * Merge on create
     *
     * @return ClauseInterface Return on create instance
     */
    public function onCreate();

    /**
     * Merge on match
     *
     * @return ClauseInterface Return on match instance
     */
    public function onMatch();

    /**
     * Optional match pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return match instance
     */
    public function optionalMatch($pattern, array $parameters = []);

    /**
     * Output field
     *
     * @param string $field Name string
     * @param string $alias Alias string
     *
     * @return ClauseInterface Return output instance
     */
    public function output($field, $alias = null);

    /**
     * Remove pattern
     *
     * @param string $pattern Pattern string
     *
     * @return ClauseInterface Return remove instance
     */
    public function remove($pattern);

    /**
     * Run query
     *
     * @return ResultInterface Return result instance
     */
    public function run();

    /**
     * Set pattern
     *
     * @param string $pattern Pattern string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return set instance
     */
    public function set($pattern, array $parameters = []);

    /**
     * Set connection instance
     *
     * @param ConnectionInterface|ResponseInterface $connection Connection instance
     *
     * @return QueryInterface Return self
     */
    public function setConnection($connection);
}
