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
     * @var ResultInterface Result instance
     */
    protected $result;

    /**
     * Statement constructor
     *
     * @param string $query Query string
     * @param array $parameters Parameters
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
     * Get parameters array
     *
     * @return null|array Return null or parameters array if set
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Get result instance
     *
     * @return null|ResultInterface Return null or result instance if set
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set parameters array
     *
     * @param array $parameters Parameters array
     *
     * @return StatementInterface Return self
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set query string
     *
     * @param string $query Query string
     *
     * @return StatementInterface Return self
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Set result instance
     *
     * @param ResultInterface $result Result instance
     *
     * @return StatementInterface Return self
     */
    public function setResult(ResultInterface $result)
    {
        $this->result = $result;

        return $this;
    }
}
