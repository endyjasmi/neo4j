<?php
/**
 * Status interface file
 *
 * @package EndyJasmi\Neo4j\Response;
 */
namespace EndyJasmi\Neo4j\Response;

/**
 * StatusInterface is an interface for status class
 */
interface StatusInterface
{
    /**
     * Status constructor
     *
     * @param ResultInterface $result Result instance
     * @param array $status Status array
     */
    public function __construct(ResultInterface $result, array $status);

    /**
     * Get result instance
     *
     * @return ResultInterface Return result instance
     */
    public function getResult();

    /**
     * Set result instance
     *
     * @param ResultInterface $result Result instance
     *
     * @return StatusInterface Return self
     */
    public function setResult(ResultInterface $result);
}
