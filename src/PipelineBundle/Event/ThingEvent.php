<?php
// src/PipelineBundle/Event/ThingEvent.php
namespace PipelineBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * ThingEvent is similar to, but not the same as a PipelineBundle\Entity\Thing
 */
class ThingEvent extends Event
{
    const EVENT_NAME = 'thing.event';

    private $_thingName;

    /*
     * Although not currently used, the $increment & $direction could
     * likely be wanted by a Listener (e.g.: for email verbiage).
     */
    private $_increment;
    private $_direction;

    /*
     * It's better to have the Controller pass in the $amount
     * rather than have a Listener fetch it from the DB,
     * so as to avoid a race condition.
     */
    private $_amount;


    /*
     * @TODO - move __set() & __get() to a base class if/when needed elsewhere.
     */
    public function __set($name, $value)
    {
        $method = "set$name";
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = "get$name";
        return $this->$method();
    }


    /**
     * Set thingName
     * 
     * @return this
     */
    public function setThingName($value)
    {
        $this->_thingName = $value;
        return $this;
    }

    /**
     * Get thingName
     * 
     * @return thingName
     */
    public function getThingName()
    {
        return $this->_thingName;
    }


    /**
     * Set increment
     * 
     * @return this
     */
    public function setIncrement($value)
    {
        $this->_increment = (int) $value;
        return $this;
    }

    /**
     * Get increment
     * 
     * @return increment
     */
    public function getIncrement()
    {
        return $this->_increment;
    }


    /**
     * Set direction
     * 
     * @return this
     */
    public function setDirection($value)
    {
        $this->_direction = $value;
        return $this;
    }

    /**
     * Get direction
     * 
     * @return direction
     */
    public function getDirection()
    {
        return $this->_direction;
    }


    /**
     * Set amount
     * 
     * @return this
     */
    public function setAmount($value)
    {
        $this->_amount = (int) $value;
        return $this;
    }

    /**
     * Get amount
     * 
     * @return amount
     */
    public function getAmount()
    {
        return $this->_amount;
    }
}
