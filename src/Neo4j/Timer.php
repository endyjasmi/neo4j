<?php namespace EndyJasmi\Neo4j;

class Timer implements TimerInterface
{
    /**
     * @var float
     */
    protected $start;

    /**
     * @var float
     */
    protected $time;

    /**
     * Get time
     *
     * @return null|float
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Restart timer
     *
     * @return TimerInterface
     */
    public function restart()
    {
        return $this->start();
    }

    /**
     * Start timer
     *
     * @return TimerInterface
     */
    public function start()
    {
        $this->start = microtime(true);

        return $this;
    }

    /**
     * Stop timer
     *
     * @return TimerInterface
     */
    public function stop()
    {
        $this->time = microtime(true) - $this->start;

        return $this;
    }
}
