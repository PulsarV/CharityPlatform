<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/tags/{slug}", name="show_tag")
     * @param Request $request
     * @return Response
     */
    public function showTagAction(Request $request)
    {

        return $this->render('@App/tag/show_tag.html.twig', [

        ]);
    }

    /**
     * @Route("/tags/{slug}/delete", name="delete_tag")
     * @param Request $request
     * @return Response
     */
    public function deleteTagAction(Request $request)
    {

        return $this->render('@App/tag/delete_tag.html.twig', [

        ]);
    }

    /**
     * @Route("/tags/{slug}/edit", name="edit_tag")
     * @param Request $request
     * @return Response
     */
    public function editTagAction(Request $request)
    {

        return $this->render('@App/tag/delete_tag.html.twig'
            , [

        ]);
    }

    /**
     * @Route("/tag-new", name="new_tag")
     * @param Request $request
     * @return Response
     */
    public function newTagAction(Request $request)
    {
        return $this->render('@App/tag/new_tag.html.twig', [

        ]);
    }

    /**
     * @Route("/tags/show", name="show_tags")
     * @param Request $request
     * @return Response
     */
    public function paginationTagAction(Request $request)
    {

    }

}

