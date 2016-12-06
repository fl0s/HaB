<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rescue;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $rescueRepository = $this->getDoctrine()->getRepository(Rescue::class);
        $nbTransport = $rescueRepository->countTransport();
        $nbRescues = $rescueRepository->count();
        $typeStats = $rescueRepository->countByType();
        $providerStats = $rescueRepository->countByProvider();

        $transport = [
            'Oui' => $nbTransport,
            'Non' => ($nbRescues - $nbTransport),
        ];

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'provider' => $providerStats,
            'transport' => $transport,
            'types' => $typeStats,
        ));
    }
}
