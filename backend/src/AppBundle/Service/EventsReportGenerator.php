<?php

namespace AppBundle\Service;

use Doctrine\Common\Collections\Collection;
use Knp\Snappy\GeneratorInterface;

class EventsReportGenerator
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

    public function generateFromEvents(array $events, $private = false)
    {
        $html = $this->twig->render('event/print.html.twig', [
            'events' => $events,
            'private' => $private,
        ]);

        $baseDir = $this->rootDir . '/../web';

        return $this->pdfGenerator->getOutputFromHtml($html, [
            'margin-top' => '60',
            'margin-bottom' => '15',
            'margin-left' => '0',
            'margin-right' => '0',
            'header-html' => $this->twig->render('pdf/header.html.twig', ['base_dir' => $baseDir]),
            'footer-html' => $this->twig->render('pdf/footer.html.twig', ['base_dir' => $baseDir]),
        ]);
    }
}
