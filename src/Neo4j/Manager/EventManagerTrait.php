<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\EventInterface;

trait EventManagerTrait
{
    /**
     * @var EventInterface
     */
    protected $event;

    /**
     * Get event instance
     *
     * @return EventInterface
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set event instance
     *
     * @param EventInterface $event
     * @return EventManagerInterface
     */
    public function setEvent(EventInterface $event)
    {
        $this->event = $event;

        return $this;
    }
}
