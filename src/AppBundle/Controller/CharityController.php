<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Charity;

class CharityController extends Controller
{
    /**
     * @Route("/charities/config/{param}/{value}", name="config_show")
     * @Method({"GET"})
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
     */
    public function indexCharityAction($page)
    {
        $pager = $this->get('app.charity_manager')->getCharityListPaginated('none', 'none', 'd', $page);

        return [
            'pager' => $pager,
        ];
    }

    /**
     * @Route("/charities/{filter}/{slug}/{sortmode}/{page}", requirements={"page": "\d+"}, defaults={"page": 1}, name="charity_index_filtered")
     * @Method({"GET"})
     * @Template("@App/Charity/indexCharity.html.twig")
     */
    public function indexFilteredCharityAction($filter, $slug, $sortmode, $page)
    {
        $pager = $this->get('app.charity_manager')->getCharityListPaginated($filter, $slug, $sortmode, $page);

        return [
            'pager' => $pager,
        ];
    }

    /**
     * @Route("/charities/{slug}", name="charity_show")
     * @Method({"GET"})
     * @Template()
     */
    public function showCharityAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $charity = $em->getRepository('AppBundle:Charity')->findOneBy(['slug' => $slug]);

        return [
            'charity' => $charity,
        ];
    }
}
