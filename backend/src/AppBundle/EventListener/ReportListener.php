<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Log;
use AppBundle\Event\ReportEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReportListener implements EventSubscriberInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public static function getSubscribedEvents()
    {
        return [
            ReportEvent::PRINT_REPORT => 'onPrintEvent',
        ];
    }

    public function onPrintEvent(ReportEvent $event)
    {
        $log = new Log($event->getUser(), Log::REPORT_PRINT);

        $this->om->persist($log);
        $this->om->flush();
    }
}
