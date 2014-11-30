<?php namespace EndyJasmi\Neo4j;

use Illuminate\Events\Dispatcher;

interface EventInterface
{
    /**
     * Event constructor
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher);


    /**
     * Get dispatcher instance
     *
     * @return Dispatcher
     */
    public function getDispatcher();

    /**
     * Fire event
     *
     * @param string $query
     * @param array $parameters
     * @param float $time
     * @return EventInterface
     */
    public function fire($query, array $parameters, $time);

    /**
     * Listen to event
     *
     * @param callable $listener
     * @return EventInterface
     */
    public function listen(callable $listener);

    /**
     * Set dispatcher instance
     *
     * @param Dispatcher $dispatcher
     * @return EventInterface
     */
    public function setDispatcher(Dispatcher $dispatcher);
}
