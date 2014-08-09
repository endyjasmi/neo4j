<?php namespace EndyJasmi\Neo4j;

use PHPUnit_Framework_TestCase as TestCase;

class ResultTest extends TestCase
{
    protected $result = array(
        'columns' => array('name', 'age'),
        'data' => array(
            array('row' => array('Jeffrey Jasmi', 27)),
            array('row' => array('Endy Jasmi', 24)),
            array('row' => array('Donney Jasmi', 19))
        ),
        'stats' => array(
            'contains_updates' => true
        )
    );

    public function testCountable()
    {
        $result = new Result($this->result);

        $this->assertCount(3, $result);
    }

    public function testArrayAccess()
    {
        $result = new Result($this->result);

        $jeffrey = $result[0];
        $endy = $result[1];
        $donney = $result[2];

        $this->assertEquals(27, $jeffrey['age']);
        $this->assertEquals('Endy Jasmi', $endy['name']);
        $this->assertEquals(19, $donney['age']);
    }

    public function testIterator()
    {
        $result = new Result($this->result);
        $jasmi = array();

        foreach ($result as $person) {
            $jasmi[] = $person;
        }

        $this->assertCount(3, $jasmi);
        $this->assertEquals(24, $jasmi[1]['age']);
    }

    public function testToArray()
    {
        $result = new Result($this->result);
        $jasmi = $result->toArray();

        $this->assertInternalType('array', $jasmi);
        $this->assertCount(3, $jasmi);
    }

    public function testToJson()
    {
        $result = new Result($this->result);
        $jasmi = $result->toJson();

        $this->assertEquals(
            '[{"name":"Jeffrey Jasmi","age":27},{"name":"Endy Jasmi","age":24},{"name":"Donney Jasmi","age":19}]',
            $jasmi
        );
    }

    public function testGetStatus()
    {
        $result = new Result($this->result);
        $status = $result->getStatus();

        $this->assertInstanceOf(
            'EndyJasmi\Neo4j\Result\Status',
            $status
        );
    }

    public function testGetColumns()
    {
        $result = new Result($this->result);
        $columns = $result->getColumns();

        $this->assertInternalType('array', $columns);
        $this->assertCount(2, $columns);
    }
}
