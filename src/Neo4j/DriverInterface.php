<?php namespace EndyJasmi\Neo4j;

use InvalidArgumentException;

interface DriverInterface
{
    /**
     * Driver constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array());

    /**
     * Begin transaction
     *
     * @param array $request
     * @return array
     */
    public function beginTransaction(array $request);

    /**
     * Commit transaction
     *
     * @param array $request
     * @param null|integer $id
     * @return array
     * @throws InvalidArgumentException If $id is not null and integer
     */
    public function commit(array $request, $id = null);

    /**
     * Execute transaction
     *
     * @param array $request
     * @param integer $id
     * @return array
     * @throws InvalidArgumentException If $id is not integer
     */
    public function execute(array $request, $id);

    /**
     * Get driver options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Get status codes html page
     *
     * @param string $url
     * @return string
     * @throws InvalidArgumentException If $url is not string
     */
    public function getStatusCodesPage($url);

    /**
     * Rollback transaction
     *
     * @param integer $id
     * @return array
     * @throws InvalidArgumentException If $id is not integer
     */
    public function rollback($id);

    /**
     * Set driver options
     *
     * @param array $options
     * @return DriverInterface
     */
    public function setOptions(array $options);
}
