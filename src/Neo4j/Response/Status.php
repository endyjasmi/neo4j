<?php
/**
 * Status class file
 *
 * @package EndyJasmi\Neo4j\Response;
 */
namespace EndyJasmi\Neo4j\Response;

use Illuminate\Support\Fluent;

/**
 * Status is a concrete implementation of status interface
 */
class Status extends Fluent implements StatusInterface
{
    /**
     * @var ResultInterface Result instance
     */
    protected $result;

    /**
     * Status constructor
     *
     * @param ResultInterface $result Result instance
     * @param array $status Status array
     */
    public function __construct(ResultInterface $result, array $status)
    {
        $this->setResult($result);

        parent::__construct($status);
    }

    /**
     * Get status value with camel cased status name
     *
     * @param string $key Camel cased status name
     *
     * @return mixed Return status value
     */
    public function __get($key)
    {
        return $this->get(snake_case($key));
    }

    /**
     * Get result instance
     *
     * @return ResultInterface Return result instance
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set result instance
     *
     * @param ResultInterface $result Result instance
     *
     * @return StatusInterface Return self
     */
    public function setResult(ResultInterface $result)
    {
        $this->result = $result;

        return $this;
    }
}
