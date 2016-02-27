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

    }

}

