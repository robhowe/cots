<?php
// src/PipelineBundle/Entity/Thing.php
namespace PipelineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="thing")
 *
 * Thing is similar to, but not the same as a PipelineBundle\Event\ThingEvent
 */
class Thing
{
    /**
     * @ORM\Column(type="string", length=100)
     * @ORM\Id
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Thing
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Thing
     */
    public function setAmount($amount)
    {
        $this->amount = (int) $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Increment amount
     *
     * @param integer $increment
     * @param string $direction  ("up" or "down")
     *
     * @return Thing
     */
    public function incrementAmount($increment, $direction)
    {
        $this->amount += ($direction === 'up') ? $increment : -$increment;

        return $this;
    }
}
