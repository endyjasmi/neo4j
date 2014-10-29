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
 * @todo Extend fluent
 */
interface StatementInterface
{
    /**
     * Statement constructor
     *
     * @param string $query Statement query
     * @param array $parameters Statement parameters
     */
    public function __construct($query, array $parameters = []);

    /**
     * Get statement parameter
     *
     * @return null|array Return null or array if set
     */
    public function getParameters();

    /**
     * Get statement query
     *
     * @return string Return statement query
     */
    public function getQuery();

    /**
     * Get statement result
     *
     * @return null|ResultInterface Return null or result instance if set
     */
    public function getResult();

    /**
     * Set statement parameters
     *
     * @param array $parameters Statement parameters
     *
     * @return StatementInterface Return self
     */
    public function setParameters(array $parameters);

    /**
     * Set statement query
     *
     * @param string $query Statement query
     *
     * @return StatementInterface Return self
     */
    public function setQuery($query);

    /**
     * Set statement result
     *
     * @param ResultInterface $result Statement result
     *
     * @return StatementInterface Return self
     */
    public function setResult(ResultInterface $result);
}
