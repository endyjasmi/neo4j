<?php
/**
 * Driver interface file
 *
 * @package EndyJasmi\Neo4j;
 */
namespace EndyJasmi\Neo4j;

use InvalidArgumentException;

/**
 * DriverInterface is an interface for driver class
 */
interface DriverInterface
{
    /**
     * Driver options
     *
     * @param array $options Driver options
     */
    public function __construct(array $options = []);

    /**
     * Begin a new transaction
     *
     * @param array $request Transaction request
     *
     * @return array Return transaction response
     */
    public function beginTransaction(array $request);

    /**
     * Commit a transaction
     *
     * @param array $request Transaction request
     *
     * @return array Return transaction response
     */
    public function commitTransaction(array $request);

    /**
     * Execute an open transaction
     *
     * @param array $request Transaction request
     *
     * @return array Return transaction response
     *
     * @throws InvalidArgumentException If request does not have id
     */
    public function executeTransaction(array $request);

    /**
     * Rollback an open transaction
     *
     * @param array $request Transaction request
     *
     * @return array Return transaction response
     *
     * @throws InvalidArgumentException If request does not have id
     */
    public function rollbackTransaction(array $request);

    /**
     * Set driver options
     *
     * @param array $options Driver options
     *
     * @return DriverInterface Return self
     */
    public function setOptions(array $options);
}
