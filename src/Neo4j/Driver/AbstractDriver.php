<?php namespace EndyJasmi\Neo4j\Driver;

use Buzz\Client\ClientInterface;
use Buzz\Message\Request;
use Buzz\Message\Response;
use EndyJasmi\Neo4j\DriverInterface;
use InvalidArgumentException;

abstract class AbstractDriver implements DriverInterface
{
    /**
     * Create client instance
     *
     * @return ClientInterface
     */
    abstract public function createClient();

    /**
     * @var array
     */
    protected $options = [
        'scheme' => 'http',
        'host' => 'localhost',
        'port' => 7474,
        'username' => '',
        'password' => ''
    ];

    /**
     * Create request instance
     *
     * @param string $method
     * @param string $path
     * @param array $content
     * @return Request
     * @throws InvalidArgumentException If $method is not string
     * @throws InvalidArgumentException If $path is not string
     */
    public function createRequest($method, $path, array $content = [])
    {
        // Validate arguments
        if (! is_string($method)) {
            throw new InvalidArgumentException('$method is not a string.');
        }

        if (! is_string($path)) {
            throw new InvalidArgumentException('$path is not a string.');
        }

        // Initial setup
        $content = json_encode($content);
        $host = $this->getHost();
        $options = $this->options;

        // Create request
        $request = new Request($method, $path, $host);

        // Set request header and body then return
        $request->setHeaders(
            [
                'Accept' => 'application/json; charset=UTF-8',
                'Content-Type' => 'application/json',
                'X-Stream' => 'true'
            ]
        );

        $request->addHeader(
            'Authorization: Basic ' .
            base64_encode("{$options['username']}:{$options['password']}")
        );

        $request->setContent($content);

        return $request;
    }

    /**
     * Get host from options
     *
     * @return string
     */
    protected function getHost()
    {
        $options = $this->options;

        return "{$options['scheme']}://{$options['host']}:{$options['port']}";
    }

    /**
     * Send request
     *
     * @param Request $request
     * @return Response
     */
    protected function send(Request $request)
    {
        // Initial setup
        $client = $this->createClient();

        // Send request and return response
        $response = new Response();
        $client->send($request, $response);

        return $response;
    }

    /**
     * Driver constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->setOptions($options);
    }

    /**
     * Begin transaction
     *
     * @param array $request
     * @return array
     */
    public function beginTransaction(array $request)
    {
        // Initial setup
        $method = 'post';
        $path = '/db/data/transaction';

        // Send request
        $request = $this->createRequest($method, $path, $request);
        $response = $this->send($request);

        // Get id from location header
        $location = $response->getHeader('location');
        $location = explode('/', $location);
        $id = array_pop($location);

        // Get response array from body and return
        $content = $response->getContent();
        $response = json_decode($content, true);

        return [$id, $response];
    }

    /**
     * Commit transaction
     *
     * @param array $request
     * @param null|integer $id
     * @return array
     * @throws InvalidArgumentException If $id is not null and not integer
     */
    public function commit(array $request, $id = null)
    {
        // Validate arguments
        if (! is_null($id) && ! is_integer($id)) {
            throw new InvalidArgumentException('$id is not a null or integer.');
        }

        // Initial setup
        $method = 'post';
        $path = '/db/data/transaction/commit';

        if (is_integer($id)) {
            $path = str_replace('/commit', "/$id/commit", $path);
        }

        // Send request
        $request = $this->createRequest($method, $path, $request);
        $response = $this->send($request);

        // Get response array from body and return
        $content = $response->getContent();
        $response = json_decode($content, true);

        return [$id, $response];
    }

    /**
     * Execute transaction
     *
     * @param array $request
     * @param integer $id
     * @return array
     * @throws InvalidArgumentException If $id is not integer
     */
    public function execute(array $request, $id)
    {
        // Validate arguments
        if (! is_integer($id)) {
            throw new InvalidArgumentException('$id is not an integer.');
        }

        // Initial setup
        $method = 'post';
        $path = str_replace('{id}', $id, '/db/data/transaction/{id}');

        // Send request
        $request = $this->createRequest($method, $path, $request);
        $response = $this->send($request);

        // Get response array from body and return
        $content = $response->getContent();
        $response = json_decode($content, true);

        return [$id, $response];
    }

    /**
     * Get driver options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get status codes html page
     *
     * @param string $url
     * @return string
     * @throws InvalidArgumentException If $url is not string
     */
    public function getStatusCodesPage($url)
    {
        // Validate arguments
        if (! is_string($url)) {
            throw new InvalidArgumentException('$url is not a string.');
        }

        // Initial setup
        $client = $this->createClient();
        $method = 'get';

        // Parse url
        $url = parse_url($url);
        $host = "{$url['scheme']}://{$url['host']}";
        $path = $url['path'];

        // Send request and return response content
        $request = new Request($method, $path, $host);
        $response = new Response;

        $client->send($request, $response);

        return $response->getContent();
    }

    /**
     * Rollback transaction
     *
     * @param integer $id
     * @return array
     * @throws InvalidArgumentException If $id is not integer
     */
    public function rollback($id)
    {
        // Validate arguments
        if (! is_integer($id)) {
            throw new InvalidArgumentException('$id is not an integer.');
        }

        // Initial setup
        $method = 'delete';
        $path = str_replace('{id}', $id, '/db/data/transaction/{id}');

        // Send request
        $request = $this->createRequest($method, $path);
        $response = $this->send($request);

        // Get response array from body and return
        $content = $response->getContent();
        $response = json_decode($content, true);

        return [$id, $response];
    }

    /**
     * Set driver options
     *
     * @param array $options
     * @return DriverInterface
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }
}
