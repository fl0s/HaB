<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    /**
     * @Route("/event", name="event-list")
     */
    public function indexAction(Request $request)
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * @Route("/event/create", name="event-create")
     */
    public function createAction(Request $request)
    {
        $event = new Event();

        $form = $this->createFormBuilder($event)
            ->add('date', 'date', [
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'placeholder' => 'jj/mm/aaaa',
            ])
            ->add('description', 'textarea', [
                'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $om = $this->getDoctrine()->getManager();

            $om->persist($event);
            $om->flush($event);

            return $this->redirectToRoute('event-list');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/event/{id}/rescue/", name="event-detail")
     */
    public function rescueAction(Event $event)
    {
        $types = [];
        $transport = ["Oui" => 0, "Non" => 0];
        $from = [
            "18" => 3,
            "PC" => 1,
            "15" => 0,
        ];

        foreach ($event->getRescues() as $rescue) {
            $name = $rescue->getType()->getName();
            if (array_key_exists($name, $types)) {
                $types[$name]++;
            } else {
                $types[$name] = 1;
            }

            $rescue->isTransport() ? $transport['Oui']++ : $transport['Non']++;
        }

        return $this->render('event/rescue_index.html.twig', [
            'event' => $event,
            'types' => $types,
            'transport' => $transport,
            'from' => $from,
        ]);
    }
}
