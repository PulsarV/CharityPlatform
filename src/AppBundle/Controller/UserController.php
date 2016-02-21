<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/users/{slug}", name="show_user")
     * @param Request $request
     * @return Response
     */
    public function showUserAction(Request $request)
    {

        return $this->render('@App/user/show_user.html.twig', [

        ]);
    }

    /**
     * @Route("/users/{slug}/delete", name="delete_user")
     * @param Request $request
     * @return Response
     */
    public function deleteUserAction(Request $request)
    {

        return $this->render('@App/user/delete_user.html.twig', [

        ]);
    }

    /**
     * @Route("/users/{slug}/edit", name="edit_user")
     * @param Request $request
     * @return Response
     */
    public function editUserAction(Request $request)
    {

        return $this->render('@App/user/edit_user.html.twig', [

        ]);
    }

    /**
     * @Route("/users/show", name="show_charities")
     * @param Request $request
     * @return Response
     */
    public function paginationUserAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT a FROM AcmeMainBundle:Article a";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        // parameters to template
        return $this->render('@App/user/pagination_users.html.twig',
            ['pagination' => $pagination]);
    }

}

