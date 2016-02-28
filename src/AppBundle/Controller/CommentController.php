<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @Route("/comments/{slug}", name="show_comment")
     * @param Request $request
     * @return Response
     */
    public function showCommentAction(Request $request)
    {

        return $this->render('@App/comment/show_comment.html.twig', [

        ]);
    }

    /**
     * @Route("/comments/{slug}/delete", name="delete_comment")
     * @param Request $request
     * @return Response
     */
    public function deleteCommentAction(Request $request)
    {

        return $this->render('@App/comment/delete_comment.html.twig', [

        ]);
    }

    /**
     * @Route("/comments/{slug}/edit", name="edit_comment")
     * @param Request $request
     * @return Response
     */
    public function editCommentAction(Request $request)
    {

        return $this->render('@App/comment/edit_comment.html.twig', [

        ]);
    }

    /**
     * @Route("/comments/show", name="show_comments")
     * @param Request $request
     * @return Response
     */
    public function paginationCommentAction(Request $request)
    {

    }

}

