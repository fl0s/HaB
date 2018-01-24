<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RescueRepository")
 */
class Rescue
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Datetime
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @var RescueType
     * @ORM\ManyToOne(targetEntity="RescueType")
     */
    private $type;

    /**
     * @var EvacuationProvider|null
     * @ORM\ManyToOne(targetEntity=EvacuationProvider::class)
     */
    private $evacuationProvider;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $lon;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @var RescueProvider
     * @ORM\ManyToOne(targetEntity="RescueProvider")
     */
    private $provider;

    /**
     * @var Event
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="rescues")
     */
    private $event;

    public function __construct()
    {
        $this->time = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Datetime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \Datetime $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return RescueType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param RescueType $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return EvacuationProvider|null
     */
    public function getEvacuationProvider()
    {
        return $this->evacuationProvider;
    }

    /**
     * @return bool
     */
    public function hasEvacuation()
    {
        return $this->evacuationProvider !== null;
    }

    /**
     * @param EvacuationProvider|null $evacuationProvider
     */
    public function setEvacuationProvider($evacuationProvider)
    {
        $this->evacuationProvider = $evacuationProvider;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return float
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @param float $lon
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return RescueProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param RescueProvider $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }
}
