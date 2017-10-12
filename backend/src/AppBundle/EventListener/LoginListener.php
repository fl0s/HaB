<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Log;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class LoginListener implements EventSubscriberInterface
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
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onLoginSuccess',
        ];
    }

    public function onLoginSuccess(AuthenticationEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof User) {
            $log = new Log($user, Log::USER_LOGIN);

            $this->om->persist($log);
            $this->om->flush();
        }
    }
}
