<?php namespace EndyJasmi\Neo4j;

use Illuminate\Events\Dispatcher;

class Event implements EventInterface
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Event constructor
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->setDispatcher($dispatcher);
    }


    /**
     * Get dispatcher instance
     *
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Fire event
     *
     * @param string $query
     * @param array $parameters
     * @param float $time
     * @return EventInterface
     */
    public function fire($query, array $parameters, $time)
    {
        $this->getDispatcher()
            ->fire('neo4j.query', [$query, $parameters, $time]);

        return $this;
    }

    /**
     * Listen to event
     *
     * @param callable $listener
     * @return EventInterface
     */
    public function listen(callable $listener)
    {
        $this->getDispatcher()
            ->listen('neo4j.query', $listener);

        return $this;
    }

    /**
     * Set dispatcher instance
     *
     * @param Dispatcher $dispatcher
     * @return EventInterface
     */
    public function setDispatcher(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }
}
