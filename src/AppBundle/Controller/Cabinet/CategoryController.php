<?php

namespace AppBundle\Controller\Cabinet;

use AppBundle\Entity\Charity;
use AppBundle\Form\Cabinet\CharityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin", name="cabinet_charity")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/charity-manager/{page}", requirements={"page": "\d+"}, defaults={"page": 1}, name="charity_manager_index")
     * @Method("GET")
     * @Template()
     */
    public function indexCharityAction($page)
    {
        $pager = $this->get('app.charity_manager')->getCharityListPaginated(
            'none',
            'none',
            'd',
            $page,
            $this->container->getParameter('app.cabinet_paginator_count_per_page')
        );

        return [
            'pager' => $pager,
        ];
    }

    /**
     * @Route("/charity-new", name="charity_new")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function newCharityAction(Request $request)
    {
        $charity = new Charity();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CharityType::class, $charity);

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($charity);
                $this->get('app.charity_manager')->setBanner($charity);
                $em->flush();

                return $this->redirectToRoute('charity_index');
            }
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/charities/{slug}/delete", name="charity_delete")
     * @Method({"GET", "DELETE"})
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
        $form = $this->createDeleteArticleForm($charity);
        if($request->getMethod() == 'DELETE') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->remove($charity);
                $em->flush();
                return $this->redirectToRoute('charity_manager_index');
            }
        }


        return [
            'delete_form' => $form->createView(),
            'charity' => $charity,
        ];
    }

    /**
     * @param Charity $charity
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteArticleForm(Charity $charity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('charity_delete', array('slug' => $charity->getSlug())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @Route("/charities/{slug}/edit", name="charity_edit")
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
        $banner = $charity->getBanner();

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CharityType::class, $charity);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $files = $request->files->get('charity');
                $this->get('app.charity_manager')->setBanner($charity, $banner, $files);
                $em->flush();

                return $this->redirectToRoute('charity_index');
            }
        }

        return [
            'form' => $form->createView(),
            'charity' => $charity,
        ];
    }
}
