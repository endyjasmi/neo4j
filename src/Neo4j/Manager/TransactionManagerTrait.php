<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\TransactionInterface;

trait TransactionManagerTrait
{
    /**
     * @var TransactionInterface
     */
    protected $transaction;

    /**
     * Get transaction instance
     *
     * @return TransactionInterface
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set transaction instance
     *
     * @param TransactionInterface $transaction
     * @return TransactionManagerInterface
     */
    public function setTransaction(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }
}
