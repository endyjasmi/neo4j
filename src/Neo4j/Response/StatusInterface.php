<?php
/**
 * Status interface file
 *
 * @package EndyJasmi\Neo4j\Response;
 */
namespace EndyJasmi\Neo4j\Response;

/**
 * StatusInterface is an interface for status class
 * @todo Extend fluent
 */
interface StatusInterface
{
    /**
     * Status constructor
     *
     * @param ResultInterface $result Status result
     * @param array $status Raw status
     */
    public function __construct(ResultInterface $result, array $status);

    /**
     * Get status with camel cased status
     *
     * @param string $key Camel cased status name
     *
     * @return mixed Return status value
     */
    public function __get($key);

    /**
     * Get status result
     *
     * @return ResultInterface Return status result
     */
    public function getResult();

    /**
     * Set status result
     *
     * @param ResultInterface $result Status result
     *
     * @return StatusInterface Return self
     */
    public function setResult(ResultInterface $result);
}
