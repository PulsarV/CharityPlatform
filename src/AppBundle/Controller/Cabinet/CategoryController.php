<?php

namespace AppBundle\Controller\Cabinet;

use AppBundle\Entity\Category;
use AppBundle\Form\Cabinet\CategoryType;
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
     * @Route("/category-manager/{page}", requirements={"page": "\d+"}, defaults={"page": 1}, name="category_manager_index")
     * @Method("GET")
     * @Template()
     */
    public function indexCategoryAction($page)
    {
        $pager = $this->get('app.category_manager')->getCharityListPaginated(
            $page,
            $this->container->getParameter('app.cabinet_paginator_count_per_page')
        );

        return [
            'pager' => $pager,
        ];
    }

    /**
     * @Route("/category-new", name="category_new")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CategoryType::class, $category);

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($category);
                $em->flush();

                return $this->redirectToRoute('category_manager_index');
            }
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/categories/{slug}/delete", name="category_delete")
     * @Method({"GET", "DELETE"})
     * @Template()
     * @param $slug
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function deleteCategoryAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em
            ->getRepository('AppBundle:Category')
            ->findOneBy(
                [
                    'slug' => $slug,
                ]);

        if (!$category) {
            throw $this->createNotFoundException(
                'Unable to find Category..'
            );
        }
        $form = $this->createDeleteCategoryForm($category);
        if($request->getMethod() == 'DELETE') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->remove($category);
                $em->flush();
                return $this->redirectToRoute('category_manager_index');
            }
        }


        return [
            'delete_form' => $form->createView(),
            'category' => $category,
        ];
    }

    /**
     * @param Category $category
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteCategoryForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('slug' => $category->getSlug())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @Route("/categories/{slug}/edit", name="category_edit")
     * @Template()
     * @param $slug
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function editCategoryAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em
            ->getRepository('AppBundle:Category')
            ->findOneBy(
                [
                    'slug' => $slug,
                ]);

        if (!$category) {
            throw $this->createNotFoundException(
                'Unable to find Category..'
            );
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CategoryType::class, $category);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $this->redirectToRoute('category_manager_index');
            }
        }

        return [
            'form' => $form->createView(),
            'category' => $category,
        ];
    }
}
