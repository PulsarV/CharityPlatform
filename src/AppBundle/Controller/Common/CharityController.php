<?php

namespace AppBundle\Controller\Common;

use AppBundle\Form\Common\FindCharityModel;
use AppBundle\Form\Common\FindCharityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CharityController extends Controller
{
    /**
     * @Route("/charities/config/{param}/{value}", name="config_show")
     * @Method({"GET"})
     * @param Request $request
     * @param $param
     * @param $value
     * @return RedirectResponse
     */
    public function configShowAction(Request $request, $param, $value)
    {
        $this->get('app.charity_manager')->configShow($param, $value);

        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * @Route("/charities/{page}", requirements={"page": "\d+"}, defaults={"page": 1}, name="charity_index")
     * @Method({"GET"})
     * @Template()
     * @param $page
     * @return array
     */
    public function indexCharityAction($page)
    {
        $pager = $this->get('app.charity_manager')
            ->getCharityListPaginated(
                'none',
                'none',
                'd',
                $page,
                $this->container->getParameter('app.paginator_count_per_page')
            );

        return [
            'pager' => $pager,
        ];
    }

    /**
     * @Route("/charities/{filter}/{slug}/{sortmode}/{page}", requirements={"page": "\d+"}, defaults={"page": 1}, name="charity_index_filtered")
     * @Method({"GET"})
     * @Template("@App/Common/Charity/indexCharity.html.twig")
     * @param $filter
     * @param $slug
     * @param $sortmode
     * @param $page
     * @return array
     */
    public function indexFilteredCharityAction($filter, $slug, $sortmode, $page)
    {
        $pager = $this->get('app.charity_manager')
            ->getCharityListPaginated(
                $filter,
                $slug,
                $sortmode,
                $page,
                $this->container->getParameter('app.paginator_count_per_page')
            );

        return [
            'pager' => $pager,
        ];
    }

    /**
     * @Route("/charities/{slug}", name="charity_show")
     * @Method({"GET"})
     * @Template()
     * @param $slug
     * @return array
     */
    public function showCharityAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $charity = $em->getRepository('AppBundle:Charity')->findOneBy(['slug' => $slug]);

        return [
            'charity' => $charity,
        ];
    }

    /**
     * @param Request $request
     * @return array|RedirectResponse
     * @Route("/charities-find-form", name="charity_find_form")
     * @Method({"POST"})
     * @Template()

     */
    public function findCharitiesFormAction(Request $request)
    {
        $charity = new FindCharityModel();
        $form = $this->createForm(FindCharityType::class, $charity, [
            'action' => $this->generateUrl('charity_find_form'),
        ]);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $criteria = $this->get('app.charity_manager')->generateCriteria($form);

                return $this->redirectToRoute(
                    'charity_find_index',
                    [
                        'criteria' => $criteria,
                        'searchQuery' => $form->get('searchQuery')->getData(),

// maybe next line will be used for escaping
//                        'searchQuery' => filter_var($form->get('searchQuery')->getData(), FILTER_SANITIZE_STRING),

                        'page' => 1,
                    ],
                    302
                );
            }
        }

        return [
            'find_form' => $form->createView()
        ];
    }

    /**
     * @Route("/search/{criteria}/{searchQuery}/{page}", name="charity_find_index")
     * @Method({"GET"})
     * @Template("@App/Common/Charity/indexCharity.html.twig")
     * @param  $criteria
     * @param $searchQuery
     * @param $page
     * @return array
     */
    public function findCharitiesResultsAction($criteria, $searchQuery, $page)
    {
        $pager = $this->get('app.charity_manager')
            ->getFindCharityListPaginated(
                $criteria,
                $searchQuery,
                $page
            );

        return [
            'pager' => $pager,
        ];
    }
}
