<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;

class Error extends Collection implements ErrorInterface
{
    use FactoryManagerTrait;

    /**
     * Error constructor
     *
     * @param FactoryInterface $factory
     * @param array $errors
     * @param boolean $throws
     * @throws Neo If $errors is not empty and $throws is true
     */
    public function __construct(FactoryInterface $factory, array $errors, $throws = true)
    {
        $this->setFactory($factory);

        foreach ($errors as $error) {
            $error = $this->getFactory()
                ->createException($error);

            $this->push($error);
        }

        if (count($this) > 0 && $throws) {
            throw $this[0];
        }
    }
}
