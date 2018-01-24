<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $privateDescription;

    /**
     * @var Collection<Rescue>
     * @ORM\OneToMany(targetEntity="Rescue", mappedBy="event" , cascade={"remove"})
     */
    private $rescues;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $rescueWithNoCare = 0;

    public function __construct()
    {
        $this->date = new \DateTime();
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
     * @return null|string
     */
    public function getPrivateDescription()
    {
        return $this->privateDescription;
    }

    /**
     * @param null|string $description
     */
    public function setPrivateDescription($description)
    {
        $this->privateDescription = $description;
    }

    /**
     * @return array
     */
    public function getRescues()
    {
        $rescues = $this->rescues->toArray();
        usort($rescues, function (Rescue $a, Rescue $b) {
            return $a->getTime() <=> $b->getTime();
        });

        return $rescues;
    }

    /**
     * @param Collection $rescues
     */
    public function setRescues($rescues)
    {
        $this->rescues = $rescues;
    }

    /**
     * @return int
     */
    public function getRescueWithNoCare()
    {
        return $this->rescueWithNoCare;
    }

    /**
     * @param $count int
     */
    public function setRescueWithNoCare($count)
    {
        $this->rescueWithNoCare = $count;
    }

    public function countTransport()
    {
        return count(array_filter($this->getRescues(), function (Rescue $e) {
            return $e->hasEvacuation();
        }));
    }

    public function getTypeStat()
    {
        $result = [];

        foreach ($this->getRescues() as $rescue) {
            if (array_key_exists($rescue->getType()->getName(), $result)) {
                $result[$rescue->getType()->getName()]['rescue']++;
                $result[$rescue->getType()->getName()]['transport'] += $rescue->hasEvacuation() ? 1 : 0;
            } else {
                $result[$rescue->getType()->getName()] = [
                    'type' => $rescue->getType(),
                    'rescue' => 1,
                    'transport' => $rescue->hasEvacuation() ? 1 : 0,
                ];
            }
        }

        ksort($result);

        return $result;
    }

    public function getProviderStat()
    {
        $result = [];

        foreach ($this->getRescues() as $rescue) {
            if (array_key_exists($rescue->getProvider()->getName(), $result)) {
                $result[$rescue->getProvider()->getName()]['rescue']++;
                $result[$rescue->getProvider()->getName()]['transport'] += $rescue->hasEvacuation() ? 1 : 0;
            } else {
                $result[$rescue->getProvider()->getName()] = [
                    'provider' => $rescue->getProvider(),
                    'rescue' => 1,
                    'transport' => $rescue->hasEvacuation() ? 1 : 0,
                ];
            }
        }

        ksort($result);

        return $result;
    }

    public function getEvacuationStat()
    {
        $result = [];

        foreach ($this->getRescues() as $rescue) {
            if ($rescue->hasEvacuation()) {
                if (array_key_exists($rescue->getEvacuationProvider()->getName(), $result)) {
                    $result[$rescue->getEvacuationProvider()->getName()]['transport'] += $rescue->hasEvacuation() ? 1 : 0;
                } else {
                    $result[$rescue->getEvacuationProvider()->getName()] = [
                        'provider' =>$rescue->getEvacuationProvider(),
                        'transport' => $rescue->hasEvacuation() ? 1 : 0,
                    ];
                }
            }
        }

        ksort($result);

        return $result;
    }
}
