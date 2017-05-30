<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RescueType;
use AppBundle\Form\RescueTypeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class RescueTypeController extends Controller
{
    /**
     * @Route("/rescue-type", name="rescue-type-index")
     */
    public function indexAction()
    {
        $rescueTypes = $this->getDoctrine()->getRepository(RescueType::class)->findAll();

        return $this->render('rescue-type/index.html.twig', array(
            'rescueTypes' => $rescueTypes,
        ));
    }

    /**
     * @Route("/rescue-type/create", name="rescue-type-create")
     */
    public function createAction(Request $request)
    {
        $rescueType = new RescueType();

        $form = $this->createForm(RescueTypeType::class, $rescueType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($rescueType);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rescue-type-index');
        }

        return $this->render('rescue-type/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/rescue-type/{id}/edit", name="rescue-type-edit")
     */
    public function editAction(RescueType $rescueType, Request $request)
    {
        $form = $this->createForm(RescueTypeType::class, $rescueType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rescue-type-index');
        }

        return $this->render('rescue-type/edit.html.twig', array(
            'rescueType' => $rescueType,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/rescue-type/{id}/remove", name="rescue-type-remove")
     */
    public function removeAction(RescueType $rescueType)
    {
        $this->getDoctrine()->getManager()->remove($rescueType);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('rescue-type-index');
    }

}
