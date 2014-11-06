<?php
/**
 * Neo4jValidator class file
 *
 * @package EndyJasmi\Laravel\Validators
 */
namespace EndyJasmi\Laravel\Validators;

use EndyJasmi\Neo4j;
use Illuminate\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Neo4jValidator is a custom laravel validation class
 */
class Neo4jValidator extends Validator
{
    /**
     * @var Neo4j Neo4j instance
     */
    protected $neo4j;

    /**
     * Create a new Validator instance.
     *
     * @param  \Symfony\Component\Translation\TranslatorInterface  $translator
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     */
    public function __construct(
        TranslatorInterface $translator,
        array $data,
        array $rules,
        array $messages = array(),
        array $customAttributes = array(),
        Neo4j $neo4j = null
    ) {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);

        $this->neo4j = $neo4j;
    }

    /**
     * Validate unique node with target property and value
     *
     * @param string $attribute Attribute name
     * @param mixed $value Attribute value
     * @param array $parameters Validation parameter
     *
     * @return boolean Return true if passed, false otherwise
     */
    public function validateUniqueNode($attribute, $value, $parameters)
    {
        // Setting up node pattern
        $label = implode(':', $parameters);
        $node = "(node:$label)";

        // Setting up parameters
        $parameters = [];
        $parameters[$attribute] = $value;

        // Building query
        $result = $this->neo4j
            ->match($node)
            ->where("node.$attribute = {{$attribute}}", $parameters)
            ->output('count(node)', 'count')
            ->run();

        return $result[0]['count'] < 1;
    }
}
