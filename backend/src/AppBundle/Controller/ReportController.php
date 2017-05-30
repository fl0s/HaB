<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * @Route("/report", name="app.report.index")
     */
    public function indexAction()
    {
        return $this->render('report/index.html.twig');
    }

    /**
     * @Route("/report/generate", name="app.report.generate")
     */
    public function reportEventsAction(Request $request)
    {
        $startDate = new \DateTime($request->query->get('start'));
        $endDate = new \DateTime($request->query->get('end'));

        $events = $this->getDoctrine()->getRepository(Event::class)->findBetweenDates($startDate, $endDate);

        $private = $this->isGranted('ROLE_ADMIN') && $request->query->has('private');

        $pdf = $this->get('app.report_generator')->generateFromEvents($events, $private);

        return new Response($pdf, Response::HTTP_OK, [
            'Content-Type'          => 'application/pdf',
            'Content-Disposition'   => 'inline; filename="file.pdf"'
        ]);
    }

    /**
     * @Route("/report/all", name="app.report.all")
     */
    public function reportAllEventsAction(Request $request)
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findBy([], ['date' => 'ASC']);

        $private = $this->isGranted('ROLE_ADMIN') && $request->query->has('private');

        $pdf = $this->get('app.report_generator')->generateFromEvents($events, $private);

        return new Response($pdf, Response::HTTP_OK, [
            'Content-Type'          => 'application/pdf',
            'Content-Disposition'   => 'inline; filename="file.pdf"'
        ]);
    }

    /**
     * @Route("/report/last", name="app.report.last")
     */
    public function reportLastEventAction(Request $request)
    {
        $lastEvent = $this->getDoctrine()->getRepository(Event::class)->findBy([], ['date' => 'DESC'], 1);

        $private = $this->isGranted('ROLE_ADMIN') && $request->query->has('private');

        $pdf = $this->get('app.report_generator')->generateFromEvents($lastEvent, $private);

        return new Response($pdf, Response::HTTP_OK, [
            'Content-Type'          => 'application/pdf',
            'Content-Disposition'   => 'inline; filename="file.pdf"'
        ]);
    }
}
