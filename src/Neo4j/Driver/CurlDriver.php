<?php
/**
 * CurlDriver class file
 *
 * @package EndyJasmi\Neo4j\Driver;
 */
namespace EndyJasmi\Neo4j\Driver;

use Buzz\Client\ClientInterface;
use Buzz\Client\Curl as Client;
use Buzz\Message\Request;
use Buzz\Message\Response;
use EndyJasmi\Neo4j\DriverInterface;
use InvalidArgumentException;

/**
 * CurlDriver is a concrete implementation of driver interface
 */
class CurlDriver implements DriverInterface
{
    /**
     * @var array Options array
     */
    protected $options = [];

    /**
     * Create host address string
     *
     * @return string Return address string
     */
    protected function createHost()
    {
        return "{$this->options['scheme']}://{$this->options['host']}:{$this->options['port']}";
    }

    /**
     * Create request instance
     *
     * @param string $method Request method
     * @param string $path Request path
     * @param array $body Request body array
     */
    protected function createRequest($method, $path, array $body)
    {
        $request = new Request($method, $path, $this->createHost());

        $request->setHeaders(
            [
                'Accept' => 'application/json; charset=UTF-8',
                'Content-Type' => 'application/json',
                'X-Stream' => 'true'
            ]
        );

        $request->addHeader(
            'Authorization: Basic ' .
            base64_encode(
                $this->options['username'] . ':' . $this->options['password']
            )
        );

        $request->setContent(json_encode($body));

        return $request;
    }

    /**
     * Send request
     *
     * This method is used internally only, it is made public for partial mocking purposes
     *
     * @param Request $request Request instance
     * @param Client $client Client instance
     * @param Response $response Response instance
     *
     * @return array Return response array
     */
    public function send(Request $request, ClientInterface $client = null, Response $response = null)
    {
        $client = $client ?: new Client;
        $response = $response ?: new Response;

        $client->send($request, $response);

        $location = $response->getHeader('location');
        $response = json_decode($response->getContent(), true);

        if (! is_null($location)) {
            $location = explode('/', $location);
            $id = array_pop($location);
            $response['id'] = (int) $id;
        }

        return $response;
    }

    /**
     * Driver constructor
     *
     * @param array $options Options array
     */
    public function __construct(array $options = [])
    {
        if (! empty($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Begin a new transaction
     *
     * @param array $request Request array
     *
     * @return array Return Response array
     */
    public function beginTransaction(array $request)
    {
        $request = $this->createRequest('post', '/db/data/transaction', $request);

        return $this->send($request);
    }

    /**
     * Commit a transaction
     *
     * @param array $request Request array
     *
     * @return array Return response array
     */
    public function commitTransaction(array $request)
    {
        $path = '/db/data/transaction/commit';

        if (isset($request['id'])) {
            $id = $request['id'];
            unset($request['id']);

            $path = "/db/data/transaction/$id/commit";
        }

        $request = $this->createRequest('post', $path, $request);

        return $this->send($request);
    }

    /**
     * Execute an open transaction
     *
     * @param array $request Request array
     *
     * @return array Return response array
     *
     * @throws InvalidArgumentException If request does not have id
     */
    public function executeTransaction(array $request)
    {
        if (! array_key_exists('id', $request)) {
            throw new InvalidArgumentException('Request does not have id');
        }

        $id = $request['id'];
        unset($request['id']);

        $request = $this->createRequest('post', "/db/data/transaction/$id", $request);

        return $this->send($request);
    }

    /**
     * Rollback an open transaction
     *
     * @param array $request Request array
     *
     * @return array Return response array
     *
     * @throws InvalidArgumentException If request does not have id
     */
    public function rollbackTransaction(array $request)
    {
        if (! array_key_exists('id', $request)) {
            throw new InvalidArgumentException('Request does not have id');
        }

        $id = $request['id'];
        unset($request['id']);

        $request = $this->createRequest('delete', "/db/data/transaction/$id", $request);

        return $this->send($request);
    }

    /**
     * Set driver options
     *
     * @param array $options Options array
     *
     * @return DriverInterface Return self
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }
}
