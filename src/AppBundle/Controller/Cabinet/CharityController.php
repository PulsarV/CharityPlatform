<?php

namespace AppBundle\Controller\Cabinet;

use AppBundle\Entity\Charity;
use AppBundle\Form\Cabinet\CharityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CharityController extends Controller
{
    /**
     * @Route("/charity-manager/{page}", requirements={"page": "\d+"}, defaults={"page": 1}, name="charity_manager_index")
     * @Method("GET")
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
     * @Route("/charity-new", name="charity_new")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $requestspreadsheets/d/1WoNdBtsxIcT9WfL2bOyn2ICu0i9MSIt-KZtF_nyripg/edit#gid=0
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
                //TODO: add default logo if banner === null
                if ($charity->getBanner() !== null) {
                    $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                    $uploadableManager->markEntityToUpload($charity, $charity->getBanner());
                }
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

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->remove($charity);
                $em->flush();

                return $this->redirectToRoute('charity_index');
            }
        }

        return [
            'form' => $form->createView(),
            'charity' => $charity,
        ];
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

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CharityType::class, $charity);

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
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
