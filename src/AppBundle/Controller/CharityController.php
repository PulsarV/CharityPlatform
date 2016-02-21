<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CharityController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        $post = "post";

        return $this->render('@App/charity/index.html.twig', [
            'post' => $post,
        ]);

    }


    /**
     * @Route("/charities/{slug}", name="show_charity")
     * @param Request $request
     * @return Response
     */
    public function showCharityAction(Request $request)
    {

        return $this->render('@App/charity/show_charity.html.twig', [

        ]);
    }


    /**
     * @Route("/charity-new", name="new_charity")
     * @param Request $request
     * @return Response
     */
    public function newCharityAction(Request $request)
    {
        return $this->render('@App/charity/new_charity.html.twig', [

        ]);
    }

    /**
     * @Route("/charities/{slug}/delete", name="delete_charity")
     * @param Request $request
     * @return Response
     */
    public function deleteCharityAction(Request $request)
    {

        return $this->render('@App/charity/delete_charity.html.twig', [

        ]);
    }

    /**
     * @Route("/charities/{slug}/edit", name="edit_charity")
     * @param Request $request
     * @return Response
     */
    public function editCharityAction(Request $request)
    {

        return $this->render('@App/charity/edit_charity.html.twig', [

        ]);
    }

    /**
     * @Route("/charities/{slug}/set-rate", name="set_rate_charity")
     * @param Request $request
     * @return Response
     */
    public function setRateCharityAction(Request $request)
    {

        return $this->render('@App/charity/set_rate_charity.html.twig', [

        ]);
    }

    /**
     * @Route("/search/{slug}", name="search_charity")
     * @param Request $request
     * @return Response
     */
    public function searchCharityAction(Request $request)
    {


        return $this->render('@App/charity/search.html.twig', [

        ]);
    }

    /**
     * @Route("/charities/show", name="show_charities")
     * @param Request $request
     * @return Response
     */
    public function paginationAction(Request $request)
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
        return $this->render('@App/charity/pagination_charity.html.twig',
            ['pagination' => $pagination]);
    }

    /**
     * @Route("/callback", name="callback")
     * @return Response
     */
    public function callbackAction()
    {

        return $this->render('@App/charity/callback.html.twig', [

        ]);
    }

    /**
     * @Route("/faq", name="faq")
     * @return Response
     */
    public function faqAction()
    {


        return $this->render('@App/charity/faq.html.twig', [

        ]);
    }
}
