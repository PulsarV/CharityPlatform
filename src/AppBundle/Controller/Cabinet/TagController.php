<?php

namespace AppBundle\Controller\Cabinet;

use AppBundle\Entity\Tag;
use AppBundle\Form\Cabinet\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin", name="cabinet_tag")
 */
class TagController extends Controller
{
    /**
     * @Route("/tag-manager/{page}", requirements={"page": "\d+"}, defaults={"page": 1}, name="tag_manager_index")
     * @Method("GET")
     * @Template()
     */
    public function indexTagAction($page)
    {
        $pager = $this->get('app.tag_manager')->getTagListPaginated(
            $page,
            $this->container->getParameter('app.cabinet_paginator_count_per_page')
        );

        return [
            'pager' => $pager,
        ];
    }

    /**
     * @Route("/tag-new", name="tag_new")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function newTagAction(Request $request)
    {
        $tag = new Tag();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(TagType::class, $tag);

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($tag);
                $em->flush();

                return $this->redirectToRoute('tag_manager_index');
            }
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/tags/{slug}/delete", name="tag_delete")
     * @Method({"GET", "DELETE"})
     * @Template()
     * @param $slug
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function deleteTagAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em
            ->getRepository('AppBundle:Tag')
            ->findOneBy(
                [
                    'slug' => $slug,
                ]);

        if (!$tag) {
            throw $this->createNotFoundException(
                'Unable to find Tag..'
            );
        }
        $form = $this->createDeleteTagForm($tag);
        if($request->getMethod() == 'DELETE') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->remove($tag);
                $em->flush();
                return $this->redirectToRoute('tag_manager_index');
            }
        }


        return [
            'delete_form' => $form->createView(),
            'tag' => $tag,
        ];
    }

    /**
     * @param Tag $tag
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteTagForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_delete', array('slug' => $tag->getSlug())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @Route("/tags/{slug}/edit", name="tag_edit")
     * @Template()
     * @param $slug
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function editTagAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em
            ->getRepository('AppBundle:Tag')
            ->findOneBy(
                [
                    'slug' => $slug,
                ]);

        if (!$tag) {
            throw $this->createNotFoundException(
                'Unable to find Tag..'
            );
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(TagType::class, $tag);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $this->redirectToRoute('tag_manager_index');
            }
        }

        return [
            'form' => $form->createView(),
            'tag' => $tag,
        ];
    }
}
