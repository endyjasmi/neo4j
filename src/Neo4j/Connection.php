<?php namespace EndyJasmi\Neo4j;

use Buzz\Message\Request;
use Buzz\Message\Response;
use EndyJasmi\Neo4j\Request as Statements;
use EndyJasmi\Neo4j\Response as Results;
use EndyJasmi\Neo4j\Statement;
use EndyJasmi\Neo4j\Statement\Parameters;
use EndyJasmi\Neo4j\Statement\Query;

class Connection
{
    const CURL = "Buzz\\Client\\Curl";

    const STREAM = "Buzz\\Client\\FileGetContents";

    protected $autoCommit = true;

    protected $driver;

    protected $options = array();

    protected $statements;
    
    protected $transaction;

    protected function autoCommit($autoCommit = null)
    {
        if (is_null($autoCommit)) {
            return $this->autoCommit;
        }

        $this->autoCommit = $autoCommit;

        return $this;
    }

    protected function createResults($response)
    {
        $results = json_decode($response->getContent(), true);

        return new Results($results);
    }

    protected function reset()
    {
        $scheme = $this->options['scheme'];
        $host = $this->options['host'];
        $port = $this->options['port'];

        $this->set("$scheme://$host:$port/db/data/transaction");

        return $this;
    }

    protected function resetStatements()
    {
        $this->statements = new Statements;

        return $this;
    }

    protected function set($transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function __construct($url = 'http://localhost:7474', $driver = self::CURL)
    {
        $this->options = parse_url($url);

        if (!function_exists('curl_version')) {
            $driver = self::STREAM;
        }

        $this->driver = new $driver;

        $this->reset();
        $this->resetStatements();
    }


    public function beginTransaction()
    {
        $request = $this->autoCommit(false)
            ->createRequest('post', $this->getTransaction());
        $request->setContent($this->statements->toJson());

        $response = $this->createResponse();

        $this->getDriver()->send($request, $response);
        $this->resetStatements()
            ->set($response->getHeader('Location'));

        return $this->createResults($response);
    }

    public function commit()
    {
        $request = $this->autoCommit(true)
            ->createRequest('post', $this->getTransaction());
        $request->setContent($this->statements->toJson());

        $response = $this->createResponse();

        $this->getDriver()->send($request, $response);
        $this->resetStatements()
            ->reset();

        return $this->createResults($response);
    }

    public function createRequest($method, $url)
    {
        $request = new Request($method);
        $request->fromUrl($url);
        $request->setHeaders(
            array(
                'Accept' => 'application/json; charset=UTF-8',
                'Content-Type' => 'application/json',
                'X-Stream' => 'true'
            )
        );

        return $request;
    }

    public function createResponse()
    {
        return new Response;
    }

    public function execute()
    {
        $request = $this->createRequest('post', $this->getTransaction());
        $request->setContent($this->statements->toJson());

        $response = $this->createResponse();

        $this->getDriver()->send($request, $response);
        $this->resetStatements();

        return $this->createResults($response);
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getTransaction()
    {
        $transaction = $this->transaction;

        if ($this->autoCommit) {
            $transaction = "$transaction/commit";
        }
        return $transaction;
    }

    public function rollback()
    {
        $request = $this->autoCommit(false)
            ->createRequest('delete', $this->getTransaction());
        $request->setContent($this->statements->toJson());

        $response = $this->createResponse();

        $this->getDriver()->send($request, $response);
        $this->resetStatements()
            ->reset()
            ->autoCommit(true);

        return $this->createResults($response);
    }

    public function statement($query, array $parameters = array())
    {
        $query = new Query($query);
        $parameters = new Parameters($parameters);
        $statement = new Statement($query, $parameters);

        $this->statements->add($statement);

        return $this;
    }
}
