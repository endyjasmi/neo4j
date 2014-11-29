<?php namespace EndyJasmi\Neo4j\Manager;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class TransactionManagerTest extends TestCase
{
    public function testGetTransactionMethod()
    {
        // Given
        $manager = new TransactionManagerStub;

        // When
        $transaction = $manager->getTransaction();

        // Expect
        $this->assertNull($transaction);
    }

    public function testSetTransactionMethod()
    {
        // Given
        $manager = new TransactionManagerStub;

        $transaction = Mockery::mock('EndyJasmi\Neo4j\TransactionInterface');

        // When
        $self = $manager->setTransaction($transaction);

        // Expect
        $this->assertSame($manager, $self);
    }
}
