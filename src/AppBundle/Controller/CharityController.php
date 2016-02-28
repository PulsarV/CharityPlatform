<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CharityController extends Controller
{
    /**
     * @Route("/charities/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="charity_index")
     * @Method({"GET"})
     * @Template()
     */
    public function indexCharityAction($page)
    {
//        $posts = "post";

        return [];

    }

//
//    /**
//     * @Route("/charities/{slug}", name="show_charity")
//     * @param Request $request
//     * @return Response
//     */
//    public function showCharityAction(Request $request)
//    {
//
//        return $this->render('@App/charity/show_charity.html.twig', [
//
//        ]);
//    }
//
//
//    /**
//     * @Route("/charity-new", name="new_charity")
//     * @param Request $request
//     * @return Response
//     */
//    public function newCharityAction(Request $request)
//    {
//        return $this->render('@App/charity/new_charity.html.twig', [
//
//        ]);
//    }
//
//    /**
//     * @Route("/charities/{slug}/delete", name="delete_charity")
//     * @param Request $request
//     * @return Response
//     */
//    public function deleteCharityAction(Request $request)
//    {
//
//        return $this->render('@App/charity/delete_charity.html.twig', [
//
//        ]);
//    }
//
//    /**
//     * @Route("/charities/{slug}/edit", name="edit_charity")
//     * @param Request $request
//     * @return Response
//     */
//    public function editCharityAction(Request $request)
//    {
//
//        return $this->render('@App/charity/edit_charity.html.twig', [
//
//        ]);
//    }
//
//    /**
//     * @Route("/charities/{slug}/set-rate", name="set_rate_charity")
//     * @param Request $request
//     * @return Response
//     */
//    public function setRateCharityAction(Request $request)
//    {
//
//        return $this->render('@App/charity/set_rate_charity.html.twig', [
//
//        ]);
//    }
//
//    /**
//     * @Route("/search/{slug}", name="search_charity")
//     * @param Request $request
//     * @return Response
//     */
//    public function searchCharityAction(Request $request)
//    {
//
//
//        return $this->render('@App/charity/search.html.twig', [
//
//        ]);
//    }
//
//    /**
//     * @Route("/charities/show", name="show_charities")
//     * @param Request $request
//     * @return Response
//     */
//    public function paginationAction(Request $request)
//    {
//
//    }
//
//    /**
//     * @Route("/callback", name="callback")
//     * @return Response
//     */
//    public function callbackAction()
//    {
//
//        return $this->render('@App/charity/callback.html.twig', [
//
//        ]);
//    }
//
//    /**
//     * @Route("/faq", name="faq")
//     * @return Response
//     */
//    public function faqAction()
//    {
//
//
//        return $this->render('@App/charity/faq.html.twig', [
//
//        ]);
//    }
}
