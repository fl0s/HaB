<?php

namespace AppBundle\Model;

use AppBundle\Entity\Event;

class EventsSummary
{
    private $totalRescue = 0;
    private $evacuation = 0;
    private $rescueWithNoCare = 0;

    private $typeStat = null;
    private $providerStat = null;
    private $evacuationStat = null;

    public function __construct($events)
    {
        /**
         * @var Event $event
         */
        foreach($events as $event)
        {
            $this->totalRescue += count($event->getRescues());
            $this->evacuation += $event->countTransport();
            $this->rescueWithNoCare += $event->getRescueWithNoCare();

            $this->computeType($event->getTypeStat());
            $this->computeProvider($event->getProviderStat());
            $this->computeEvacuation($event->getEvacuationStat());
        }
    }

    /**
     * @return int
     */
    public function getTotalRescue()
    {
        return $this->totalRescue;
    }

    /**
     * @return int
     */
    public function getEvacuation()
    {
        return $this->evacuation;
    }

    /**
     * @return int
     */
    public function getRescueWithNoCare()
    {
        return $this->rescueWithNoCare;
    }

    /**
     * @return null
     */
    public function getTypeStat()
    {
        return $this->typeStat;
    }

    /**
     * @return null
     */
    public function getProviderStat()
    {
        return $this->providerStat;
    }

    /**
     * @return null
     */
    public function getEvacuationStat()
    {
        return $this->evacuationStat;
    }

    private function computeType($stats)
    {
        if (null === $this->typeStat) {
            $this->typeStat = $stats;
            return;
        }

        foreach($stats as $key => $stat) {
            if (array_key_exists($key, $this->typeStat)) {
                $this->typeStat[$key]['rescue'] += $stat['rescue'];
                $this->typeStat[$key]['transport'] += $stat['transport'];
            } else {
                $this->typeStat[$key] = [
                    'type' => $stat['type'],
                    'rescue' => $stat['rescue'],
                    'transport' => $stat['transport'],
                ];
            }
        }
    }

    private function computeProvider($stats)
    {
        if (null === $this->providerStat) {
            $this->providerStat = $stats;
            return;
        }

        foreach($stats as $key => $stat) {
            if (array_key_exists($key, $this->providerStat)) {
                $this->providerStat[$key]['rescue'] += $stat['rescue'];
                $this->providerStat[$key]['transport'] += $stat['transport'];
            } else {
                $this->providerStat[$key] = [
                    'provider' => $stat['provider'],
                    'rescue' => $stat['rescue'],
                    'transport' => $stat['transport'],
                ];
            }
        }
    }

    private function computeEvacuation($stats)
    {
        if (null === $this->evacuationStat) {
            $this->evacuationStat = $stats;
            return;
        }

        foreach($stats as $key => $stat) {
            if (array_key_exists($key, $this->evacuationStat)) {
                $this->evacuationStat[$key]['transport'] += $stat['transport'];
            } else {
                $this->evacuationStat[$key] = [
                    'provider' => $stat['provider'],
                    'transport' => $stat['transport'],
                ];
            }
        }
    }
}
