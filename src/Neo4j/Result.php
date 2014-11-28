<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;

class Result extends Collection implements ResultInterface
{
    use FactoryManagerTrait;

    /**
     * @var array
     */
    protected $status = [];

    /**
     * @var StatementInterface
     */
    protected $statement;

    /**
     * Result constructor
     *
     * @param FactoryInterface $factory
     * @param StatementInterface $statement
     * @param array $result
     */
    public function __construct(FactoryInterface $factory, StatementInterface $statement, array $result)
    {
        $this->setFactory($factory)
            ->setStatement($statement);

        foreach ($result['data'] as $data) {
            $row = array_combine($result['columns'], $data['row']);

            $this->push($row);
        }

        $this->status = $result['stats'];
    }

    /**
     * Get statement instance
     *
     * @return StatementInterface
     */
    public function getStatement()
    {
        return $this->statement;
    }


    /**
     * Get status instance
     *
     * @return StatusInterface
     */
    public function getStatus()
    {
        return $this->getFactory()
            ->createStatus($this->status);
    }

    /**
     * Set statement instance
     *
     * @param StatementInterface $statement
     * @return ResultInterface
     */
    public function setStatement(StatementInterface $statement)
    {
        $this->statement = $statement;

        return $this;
    }
}
