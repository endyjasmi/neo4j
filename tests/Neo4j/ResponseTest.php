<?php namespace EndyJasmi\Neo4j;

use PHPUnit_Framework_TestCase as TestCase;

class ResponseTest extends TestCase
{
    protected $response = array(
        'results' => array(
            array(
                'columns' => array('name'),
                'data' => array(
                    array('row' => array('Jeffrey Jasmi'))
                ),
                'stats' => array()
            ),
            array(
                'columns' => array('name'),
                'data' => array(
                    array('row' => array('Endy Jasmi'))
                ),
                'stats' => array()
            ),
            array(
                'columns' => array('name'),
                'data' => array(
                    array('row' => array('Donney Jasmi'))
                ),
                'stats' => array()
            )
        ),
        'errors' => array()
    );

    protected $errors = array(
        'results' => array(),
        'errors' => array(
            array(
                'code' => 'Neo.ClientError.Statement.InvalidSyntax',
                'message' => 'Test error'
            )
        )
    );

    public function testCountable()
    {
        $response = new Response($this->response);

        $this->assertCount(3, $response);
    }

    public function testArrayAccess()
    {
        $response = new Response($this->response);

        $result = $response[0];

        $this->assertInstanceOf('EndyJasmi\Neo4j\Result', $result);
    }

    public function testIterator()
    {
        $response = new Response($this->response);
        $results = array();

        foreach ($response as $result) {
            $results[] = $result;
        }

        $this->assertCount(3, $results);
        $this->assertInstanceOf('EndyJasmi\Neo4j\Result', $results[0]);
    }

    public function testToArray()
    {
        $response = new Response($this->response);
        $response = $response->toArray();

        $this->assertInternalType('array', $response);
        $this->assertCount(3, $response);
    }

    public function testToJson()
    {
        $response = new Response($this->response);
        $response = $response->toJson();

        $this->assertEquals(
            '[[{"name":"Jeffrey Jasmi"}],[{"name":"Endy Jasmi"}],[{"name":"Donney Jasmi"}]]',
            $response
        );
    }

    /**
     * @expectedException EndyJasmi\Neo4j\StatusCodes\Neo
     */
    public function testErrorStatusCode()
    {
        $response = new Response($this->errors);
    }

    public function testCreateResult()
    {
        $response = new Response($this->response);
        $result = $response->createResult($this->response['results'][0]);

        $this->assertInstanceOf('EndyJasmi\Neo4j\Result', $result);
    }
}
