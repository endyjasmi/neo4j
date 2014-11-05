<?php
/**
 * OrderByClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

/**
 * OrderByClause is a concrete implementation of clause interface
 */
class OrderByClause extends AbstractClause
{
    /**
     * @var array Field array
     */
    protected $fields = [];

    /**
     * Order by clause constructor
     *
     * @param ClauseInterface $parent Parent instance
     * @param string $field Name string
     * @param string $type Type string
     */
    public function __construct(ClauseInterface $parent, $field, $type = null)
    {
        $this->orderBy($field, $type)
            ->parent = $parent;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        $fields = array_map(
            function ($field) {
                $type = $field[1];
                $field = $field[0];

                if (! is_null($type)) {
                    $field = "$field DESC";
                }

                return $field;
            },
            $this->fields
        );

        $fields = implode(', ', $fields);

        return "ORDER BY $fields";
    }

    /**
     * Order by field
     *
     * @param string $field Name string
     * @param string $type Type string
     *
     * @return ClauseInterface Return self
     */
    public function orderBy($field, $type = null)
    {
        $this->fields[] = [$field, $type];

        return $this;
    }
}
