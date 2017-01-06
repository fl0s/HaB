<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * @Route("/event", name="event-list")
     */
    public function indexAction()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findBy([], ['date' => 'ASC']);

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

        $form = $this->createForm(EventType::class, $event);

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
     * @Route("/event/{id}/edit", name="event-edit")
     */
    public function editAction(Event $event, Request $request)
    {
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event-list');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/event/{id}/remove", name="event-delete")
     */
    public function removeAction(Event $event)
    {
        $this->getDoctrine()->getManager()->remove($event);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('event-list');
    }

    /**
     * @Route("/event/{id}/rescue/", name="event-detail")
     */
    public function rescueAction(Event $event)
    {
        $transport = [
            "Oui" => $event->countTransport(),
            "Non" => count($event->getRescues()) - $event->countTransport()
        ];

        $provider = [];
        foreach ($event->getProviderStat() as $stat) {
            $provider[$stat['provider']->getName()] = $stat['rescue'];
        }

        $types = [];
        foreach ($event->getTypeStat() as $stat) {
            $types[$stat['type']->getName()] = $stat['rescue'];
        }

        return $this->render('event/rescue_index.html.twig', [
            'event' => $event,
            'types' => $types,
            'transport' => $transport,
            'provider' => $provider,
        ]);
    }

    /**
     * @Route("/events/print", name="events-print")
     */
    public function printAction()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findBy([], ['date' => 'ASC']);

        $html = $this->renderView('event/print.html.twig', [
            'events' => $events,
        ]);

        $baseDir = $this->get('kernel')->getRootDir() . '/../web';

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, [
                'margin-top' => '51',
                'margin-bottom' => '18',
                'margin-left' => '0',
                'margin-right' => '0',
                'header-html' => $this->renderView('pdf/header.html.twig', ['base_dir' => $baseDir]),
                'footer-html' => $this->renderView('pdf/footer.html.twig', ['base_dir' => $baseDir]),
            ]),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="file.pdf"'
            )
        );
    }
}
