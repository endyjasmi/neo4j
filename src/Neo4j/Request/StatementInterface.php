<?php
/**
 * Statement interface file
 *
 * @package EndyJasmi\Neo4j\Request;
 */
namespace EndyJasmi\Neo4j\Request;

use EndyJasmi\Neo4j\Response\ResultInterface;

/**
 * StatementInterface is an interface for statement class
 */
interface StatementInterface
{
    /**
     * Statement constructor
     *
     * @param string $query Query string
     * @param array $parameters Parameters
     */
    public function __construct($query, array $parameters = []);

    /**
     * Get parameters array
     *
     * @return null|array Return null or parameters array if set
     */
    public function getParameters();

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery();

    /**
     * Get result instance
     *
     * @return null|ResultInterface Return null or result instance if set
     */
    public function getResult();

    /**
     * Get running time in second
     *
     * @return null|float Return null or float if set
     */
    public function getTime();

    /**
     * Set parameters array
     *
     * @param array $parameters Parameters array
     *
     * @return StatementInterface Return self
     */
    public function setParameters(array $parameters);

    /**
     * Set query string
     *
     * @param string $query Query string
     *
     * @return StatementInterface Return self
     */
    public function setQuery($query);

    /**
     * Set result instance
     *
     * @param ResultInterface $result Result instance
     *
     * @return StatementInterface Return self
     */
    public function setResult(ResultInterface $result);
}
