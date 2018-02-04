<?php

namespace AppBundle\Service;

use AppBundle\Model\EventsSummary;
use Knp\Snappy\GeneratorInterface;

class SummaryReportGenerator
{
    private $rootDir;
    private $twig;
    private $pdfGenerator;

    public function __construct($rootDir, \Twig_Environment $twig, GeneratorInterface $pdfGenerator)
    {
        $this->rootDir = $rootDir;
        $this->twig = $twig;
        $this->pdfGenerator = $pdfGenerator;
    }

    public function generateFromEvents(array $events, \DateTime $start, \DateTime $end)
    {
        $eventsSummary = new EventsSummary($events);

        $html = $this->twig->render('report/summary.html.twig', [
            'eventsSummary' => $eventsSummary,
            'start' => $start,
            'end' => $end,
        ]);

        $baseDir = $this->rootDir . '/../web';

        return $this->pdfGenerator->getOutputFromHtml($html, [
            'margin-top' => '50',
            'margin-bottom' => '15',
            'margin-left' => '0',
            'margin-right' => '0',
            'header-html' => $this->twig->render('pdf/header.html.twig', ['base_dir' => $baseDir]),
            'footer-html' => $this->twig->render('pdf/footer.html.twig', ['base_dir' => $baseDir]),
        ]);
    }
}
