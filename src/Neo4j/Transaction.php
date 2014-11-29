<?php namespace EndyJasmi\Neo4j;

use EndyJasmi\Neo4j\Manager\DriverManagerTrait;
use EndyJasmi\Neo4j\Manager\FactoryManagerTrait;
use InvalidArgumentException;

class Transaction implements TransactionInterface
{
    use DriverManagerTrait;
    use FactoryManagerTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Transaction constructor
     *
     * @param FactoryInterface $factory
     * @param DriverInterface $driver
     * @param RequestInterface $request
     */
    public function __construct(FactoryInterface $factory, DriverInterface $driver, RequestInterface $request)
    {
        $this->setFactory($factory)
            ->setDriver($driver);

        $input = $request->toArray();
        $output = $this->getDriver()
            ->beginTransaction($input);

        list($id, $response) = $output;

        $response = $this->getFactory()
            ->createResponse($request, $response);

        $this->setId($id)
            ->response = $response;
    }

    /**
     * Commit transaction
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function commit(RequestInterface $request)
    {
        $id = $this->getId();
        $input = $request->toArray();
        $output = $this->getDriver()
            ->commit($input, $id);

        list($id, $response) = $output;

        return $this->response = $this->getFactory()
            ->createResponse($request, $response);
    }

    /**
     * Execute transaction
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function execute(RequestInterface $request)
    {
        $id = $this->getId();
        $input = $request->toArray();
        $output = $this->getDriver()
            ->execute($input, $id);

        list($id, $response) = $output;

        return $this->response = $this->getFactory()
            ->createResponse($request, $response);
    }

    /**
     * Get transaction id
     *
     * @return null|integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get transaction response
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Rollback transaction
     *
     * @return ResponseInterface
     */
    public function rollback()
    {
        $id = $this->getId();
        $output = $this->getDriver()
            ->rollback($id);
    }

    /**
     * Set transaction id
     *
     * @param null|integer $id
     * @return TransactionInterface
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function setId($id)
    {
        if (! is_null($id) && ! is_integer($id)) {
            throw new InvalidArgumentException('$id is not a null or integer.');
        }

        $this->id = $id;

        return $this;
    }
}
