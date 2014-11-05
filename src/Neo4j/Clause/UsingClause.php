<?php
/**
 * UsingClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

/**
 * UsingClause is a concrete implementation of clause interface
 */
class UsingClause extends AbstractClause
{
    const INDEX = 'INDEX';

    const SCAN = 'SCAN';

    /**
     * @var array Index array
     */
    protected $indexes = [];

    /**
     * Add using clause
     *
     * @param string $type Type string
     * @param string $index Index string
     *
     * @return ClauseInterface Return
     */
    protected function using($type, $index)
    {
        $this->indexes[] = [$type, $index];

        return $this;
    }

    /**
     * UsingClause constructor
     *
     * @param ClauseInterface $parent Parent instance
     * @param string $type Type string
     * @param string $index Index string
     */
    public function __construct(ClauseInterface $parent, $type, $index)
    {
        $this->using($type, $index)
            ->parent = $parent;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        $indexes = array_map(
            function ($index) {
                $type = $index[0];
                $index = $index[1];
                
                return "USING $type $index";
            },
            $this->indexes
        );

        return implode(' ', $indexes);
    }

    /**
     * Using index
     *
     * @param string $index Index string
     *
     * @return ClauseInterface Return self
     */
    public function usingIndex($index)
    {
        return $this->using(static::INDEX, $index);
    }

    /**
     * Using scan
     *
     * @param string $index Index string
     *
     * @return ClauseInterface Return self
     */
    public function usingScan($index)
    {
        return $this->using(static::SCAN, $index);
    }
}
