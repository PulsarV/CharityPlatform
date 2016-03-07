<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Charity;
use AppBundle\Form\CharityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CharityController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {
        $post = "post";

        return [
            'post' => $post,
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
