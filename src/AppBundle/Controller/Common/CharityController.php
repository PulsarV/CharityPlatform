<?php

namespace AppBundle\Controller\Common;

use AppBundle\Entity\Charity;
use AppBundle\Form\Common\FindCharityModel;
use AppBundle\Form\Common\FindCharityType;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CharityController extends Controller
{
    /**
     * @Route("/charities/config/{param}/{value}", name="config_show")
     * @Method({"GET"})
     * @param Request $request
     * @param $param
     * @param $value
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
        $pager = $this->get('app.charity_manager')->getCharityListPaginated(
            'none',
            'none',
            'd',
            $page,
            $this->container->getParameter('app.paginator_count_per_page')
        );

        return [
            'pager' => $pager,
            'filter' => 'none',
            'slug' => 'none',
            'sortmode' => 'd',
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
        $pager = $this->get('app.charity_manager')->getCharityListPaginated(
            $filter,
            $slug,
            $sortmode,
            $page,
            $this->container->getParameter('app.paginator_count_per_page')
        );

        return [
            'pager' => $pager,
            'filter' => $filter,
            'slug' => $slug,
            'sortmode' => $sortmode,
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
     * @Route("/charities-find-form", name="charity_find_form")
     * @Method({"GET"})
     * @Template()
     * @return array
     */
    public function findCharitiesFormAction()
    {
        $charity = new FindCharityModel();
        $form = $this->createForm(FindCharityType::class, $charity, array(
            'action' => $this->generateUrl('charity_find_results'),
            'method' => 'GET',
        ));

        return [
            'find_form' => $form->createView()
        ];
    }

    /**
     * @Route("/charities-find-results", name="charity_find_results")
     * @Method({"GET"})
     * @Template("@App/Common/Charity/indexCharity.html.twig")
     * @return array
     */
    public function findCharitiesResultsAction(Request $request)
    {
        $title = $request->get('title');
        $finder = $this->container->get('fos_elastica.finder.app.charity');
        $pagerfanta = $finder->findPaginated($title);
        $pagerfanta->setMaxPerPage($this->container->getParameter('app.paginator_count_per_page'));
        $pagerfanta->setCurrentPage(1);

        return [
            'pager' => $pagerfanta,
            'filter' => 'none',
            'slug' => 'none',
            'sortmode' => 'd',
        ];
    }
}
