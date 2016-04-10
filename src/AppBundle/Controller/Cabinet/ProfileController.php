<?php

namespace AppBundle\Controller\Cabinet;

use AppBundle\Entity\User;
use AppBundle\Form\Cabinet\UpdateOrganizationType;
use AppBundle\Form\Cabinet\UpdatePersonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    /**
     * @Route("/users/{slug}/delete", name="user_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUserAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em
            ->getRepository('AppBundle:User')
            ->findOneBy(
                [
                    'slug' => $slug,
                ]);

        if (!$user) {
            throw $this->createNotFoundException(
                'Unable to find User..'
            );
        }

        $form = $this->createDeleteUserForm($user);

        if ($request->getMethod() == 'DELETE') {
            $form->handleRequest($request);
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('index_page');
    }

    /**
     * @param User $user
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteUserForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('slug' => $user->getSlug())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @Route("/users/{slug}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     * @Template()
     * @param $slug
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function editUserAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em
            ->getRepository('AppBundle:User')
            ->findOneBy(
                [
                    'slug' => $slug,
                ]);
        $avatar = $user->getAvatarFileName();

        $editForm = $files = null;
        if ($user->getEntityDiscr() == 'person') {
            $editForm = $this->createForm(UpdatePersonType::class, $user);
            $files = $request->files->get('update_person');
        } elseif ($user->getEntityDiscr() == 'organization') {
            $editForm = $this->createForm(UpdateOrganizationType::class, $user);
            $files = $request->files->get('update_organization');
        }
        $deleteForm = $this->createDeleteUserForm($user);

        if ($request->getMethod() === 'POST') {

            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->persist($user);
                $this->get('app.user_manager')->setAvatar($user, $avatar, $files);
                $em->flush();

                //TODO: edit redirect to show_user_profile or etc
                return $this->redirectToRoute('index_page');
            }
        }

        return [
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
            'user' => $user,
        ];
    }
}
