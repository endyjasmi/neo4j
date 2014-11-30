<?php namespace EndyJasmi\Neo4j;

use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class TransactionTest extends TestCase
{
    protected $input = [
        'statements' => []
    ];

    protected $output = [
        1,
        [
            'errors' => [],
            'response' => []
        ]
    ];

    public function setUp()
    {
        $this->factory = Mockery::mock('EndyJasmi\Neo4j\FactoryInterface');
        $this->driver = Mockery::mock('EndyJasmi\Neo4j\DriverInterface');
        $this->request = Mockery::mock('EndyJasmi\Neo4j\RequestInterface');

        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->input);

        $this->driver->shouldReceive('beginTransaction')
            ->once()
            ->andReturn($this->output);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->factory->shouldReceive('createResponse')
            ->once()
            ->andReturn($response);
    }

    public function testCommitMethod()
    {
        // Given
        $transaction = new Transaction($this->factory, $this->driver, $this->request);

        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->input);

        $this->driver->shouldReceive('commit')
            ->once()
            ->andReturn($this->output);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->factory->shouldReceive('createResponse')
            ->once()
            ->andReturn($response);

        // When
        $response = $transaction->commit($this->request);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testExecuteMethod()
    {
        // Given
        $transaction = new Transaction($this->factory, $this->driver, $this->request);

        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->input);

        $this->driver->shouldReceive('execute')
            ->once()
            ->andReturn($this->output);

        $response = Mockery::mock('EndyJasmi\Neo4j\ResponseInterface');
        $this->factory->shouldReceive('createResponse')
            ->once()
            ->andReturn($response);

        // When
        $response = $transaction->execute($this->request);

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testGetIdMethod()
    {
        // Given
        $transaction = new Transaction($this->factory, $this->driver, $this->request);

        // When
        $id = $transaction->getId();

        // Expect
        $this->assertInternalType('integer', $id);
    }

    public function testGetResponseMethod()
    {
        // Given
        $transaction = new Transaction($this->factory, $this->driver, $this->request);

        // When
        $response = $transaction->getResponse();

        // Expect
        $this->assertInstanceOf('EndyJasmi\Neo4j\ResponseInterface', $response);
    }

    public function testRollbackMethod()
    {
        // Given
        $transaction = new Transaction($this->factory, $this->driver, $this->request);

        $this->request->shouldReceive('toArray')
            ->once()
            ->andReturn($this->input);

        $this->driver->shouldReceive('rollback')
            ->once()
            ->andReturn($this->output);

        // When
        $null = $transaction->rollback();

        // Expect
        $this->assertNull($null);
    }

    public function testSetIdMethod()
    {
        // Given
        $transaction = new Transaction($this->factory, $this->driver, $this->request);

        // When
        $self = $transaction->setId(1);

        // Expect
        $this->assertSame($transaction, $self);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetIdMethodThrowInvalidArgumentException()
    {
        // Given
        $transaction = new Transaction($this->factory, $this->driver, $this->request);

        // When
        $transaction->setId('abc');
    }
}
