<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Event
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
    private $date;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @var Collection<Rescue>
     * @ORM\OneToMany(targetEntity="Rescue", mappedBy="event")
     */
    private $rescues;

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \Datetime $date
     */
    public function setDate(\DateTime$date)
    {
        $this->date = $date;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Collection
     */
    public function getRescues()
    {
        return $this->rescues;
    }

    /**
     * @param Collection $rescues
     */
    public function setRescues($rescues)
    {
        $this->rescues = $rescues;
    }
}
