<?php namespace EndyJasmi\Neo4j;

interface TimerInterface
{
    /**
     * Get time
     *
     * @return null|float
     */
    public function getTime();

    /**
     * Restart timer
     *
     * @return TimerInterface
     */
    public function restart();

    /**
     * Start timer
     *
     * @return TimerInterface
     */
    public function start();

    /**
     * Stop timer
     *
     * @return TimerInterface
     */
    public function stop();
}
