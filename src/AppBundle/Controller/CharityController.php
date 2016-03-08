<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Charity;
use AppBundle\Form\CharityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $pager = $this->get('app.charity_manager')->getCharityListPaginated('none', 'none', 'd', $page);

        return [
            'pager' => $pager,
        ];
    }

    /**
     * @Route("/charities/{filter}/{slug}/{sortmode}/{page}", requirements={"page": "\d+"}, defaults={"page": 1}, name="charity_index_filtered")
     * @Method({"GET"})
     * @Template("@App/Charity/indexCharity.html.twig")
     * @param $filter
     * @param $slug
     * @param $sortmode
     * @param $page
     * @return array
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
     * @Route("/charity-new", name="new_charity")
     * @Method({"GET"})
     * @Template()
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function newCharityAction(Request $request)
    {
        $charity = new Charity();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CharityType::class, $charity);
        $form->add('save', SubmitType::class, array('label' => 'Save'));

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($charity);
                $em->flush();

                return $this->redirectToRoute('homepage');
            }
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/charities/{slug}/delete", name="delete_charity")
     * @Method({"GET"})
     * @Template()
     * @param $slug
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function deleteCharityAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $charity = $em
            ->getRepository('AppBundle:Charity')
            ->findOneBy(
                [
                    'slug' => $slug,
                ]);

        if (!$charity) {
            throw $this->createNotFoundException(
                'Unable to find Charity..'
            );
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CharityType::class, $charity);
        $form->add('save', SubmitType::class, array('label' => 'Видалити'));

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->remove($charity);
                $em->flush();

                return $this->redirectToRoute('homepage');
            }
        }

        return [
            'form' => $form->createView(),
            'charity' => $charity,
        ];
    }

    /**
     * @Route("/charities/{slug}/edit", name="edit_charity")
     * @Method({"GET"})
     * @Template()
     * @param $slug
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function editCharityAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $charity = $em
            ->getRepository('AppBundle:Charity')
            ->findOneBy(
                [
                    'slug' => $slug,
                ]);

        if (!$charity) {
            throw $this->createNotFoundException(
                'Unable to find Charity..'
            );
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CharityType::class, $charity);
        $form->add('save', SubmitType::class, array('label' => 'Редагувати'));

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $this->redirectToRoute('homepage');
            }
        }

        return [
            'form' => $form->createView(),
            'charity' => $charity,
        ];
    }
}
