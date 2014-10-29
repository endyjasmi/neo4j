<?php
/**
 * Statement class file
 *
 * @package EndyJasmi\Neo4j\Request;
 */
namespace EndyJasmi\Neo4j\Request;

use EndyJasmi\Neo4j\Response\ResultInterface;
use Illuminate\Support\Fluent;

/**
 * Statement is a concrete implementation of statement interface
 * @todo Test
 */
class Statement extends Fluent implements StatementInterface
{
    /**
     * @var ResultInterface Statement result
     */
    protected $result;

    /**
     * Statement constructor
     *
     * @param string $query Statement query
     * @param array $parameters Statement parameters
     */
    public function __construct($query, array $parameters = [])
    {
        $this->setQuery($query)
            ->includeStats = true;

        if (! empty($parameters)) {
            $this->setParameters($parameters);
        }
    }

    /**
     * Get statement parameter
     *
     * @return null|array Return null or array if set
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get statement query
     *
     * @return string Return statement query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Get statement result
     *
     * @return null|ResultInterface Return null or result instance if set
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set statement parameters
     *
     * @param array $parameters Statement parameters
     *
     * @return StatementInterface Return self
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set statement query
     *
     * @param string $query Statement query
     *
     * @return StatementInterface Return self
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Set statement result
     *
     * @param ResultInterface $result Statement result
     *
     * @return StatementInterface Return self
     */
    public function setResult(ResultInterface $result)
    {
        $this->result = $result;

        return $this;
    }
}
