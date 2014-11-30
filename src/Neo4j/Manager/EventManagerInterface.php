<?php namespace EndyJasmi\Neo4j\Manager;

use EndyJasmi\Neo4j\EventInterface;

interface EventManagerInterface
{
    /**
     * Get event instance
     *
     * @return EventInterface
     */
    public function getEvent();

    /**
     * Set event instance
     *
     * @param EventInterface $event
     * @return EventManagerInterface
     */
    public function setEvent(EventInterface $event);
}
