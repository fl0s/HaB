<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user-index")
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * @Route("/user/create", name="user-create")
     */
    public function createAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user-index');
        }

        return $this->render('user/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/{id}/edit", name="user-edit")
     */
    public function editAction(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user-index');
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/{id}/remove", name="user-remove")
     */
    public function removeAction(User $user)
    {
        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user-index');
    }

}
