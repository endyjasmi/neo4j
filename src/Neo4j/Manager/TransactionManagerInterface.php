<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\TransactionInterface;

interface TransactionManagerInterface
{
    /**
     * Get transaction instance
     *
     * @return TransactionInterface
     */
    public function getTransaction();

    /**
     * Set transaction instance
     *
     * @param TransactionInterface $transaction
     * @return TransactionManagerInterface
     */
    public function setTransaction(TransactionInterface $transaction);
}
