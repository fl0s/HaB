<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\Rescue;
use AppBundle\Form\RescueType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;

class RescueController extends Controller
{
    /**
     * @Route("/event/{id}/rescue/create", name="rescue-create")
     */
    public function createAction(Event $event, Request $request)
    {
        $rescue = new Rescue();
        $rescue->setEvent($event);

        $form = $this->createForm(RescueType::class, $rescue);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $om = $this->getDoctrine()->getManager();

            $om->persist($rescue);
            $om->flush();

            return $this->redirectToRoute('event-detail', ['id' => $event->getId()]);
        }

        return $this->render('rescue/create.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/rescue/{id}", name="rescue-edit")
     */
    public function editAction(Rescue $rescue, Request $request)
    {
        $form = $this->createForm(RescueType::class, $rescue);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event-detail', ['id' => $rescue->getEvent()->getId()]);
        }

        return $this->render('rescue/edit.html.twig', [
            'form' => $form->createView(),
            'rescue' => $rescue,
        ]);
    }

    /**
     * @Route("/rescue/{id}/remove", name="rescue-delete")
     */
    public function removeAction(Rescue $rescue)
    {
        $eventId = $rescue->getEvent()->getId();

        $om = $this->getDoctrine()->getManager();

        $om->remove($rescue);
        $om->flush();

        return $this->redirectToRoute('event-detail', ['id' => $eventId]);
    }
}
