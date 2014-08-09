<?php namespace EndyJasmi\Neo4j;

class Error
{
    protected $code;

    protected $message;

    public function __construct(array $error)
    {
        $this->code = $error['code'];
        $this->message = $error['message'];
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
