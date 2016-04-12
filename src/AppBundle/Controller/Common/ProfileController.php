<?php

namespace AppBundle\Controller\Common;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;

/**
 * @Route("/cabinet")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/persons/profile/{slug}", name="show_person_profile")
     * @Method({"GET"})
     * @Template()
     * @param $slug
     * @return array
     */
    public function showPersonProfileAction($slug)
    {
        $em =$this->getDoctrine()->getManager();
        $profile = $em
            ->getRepository('AppBundle:Person')
            ->findOneBy([
                    'slug' => $slug
                ]);

        return [
            'profile' => $profile,
        ];
    }

    /**
     * @Route("/organizations/profile/{slug}", name="show_organization_profile")
     * @Method({"GET"})
     * @Template()
     * @param $slug
     * @return array
     */
    public function showOrganizationProfileAction($slug)
    {
        $em =$this->getDoctrine()->getManager();
        $profile = $em
            ->getRepository('AppBundle:Organization')
            ->findOneBy([
                    'slug' => $slug
                ]);

        return [
            'profile' => $profile,
        ];
    }

    /**
     * @Route("/persons", name="persons")
     * @Method({"GET"})
     * @Template()
     */
    public function personAction()
    {
        $em =$this->getDoctrine()->getManager();
        $persons = $em
            ->getRepository('AppBundle:Person')
            ->findAll();

        return [
            'persons' => $persons,
        ];
    }

    /**
     * @Route("/organizations", name="organizations")
     * @Method({"GET"})
     * @Template()
     */
    public function organizationAction()
    {
        $em =$this->getDoctrine()->getManager();
        $organizations = $em
            ->getRepository('AppBundle:Organization')
            ->findAll();

        return [
            'organizations' => $organizations,
        ];
    }

    /**
     * @Route("/check-profile", name="check_profile")
     * @Method({"GET"})
     */
    public function checkProfileAction()
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user->getEntityDiscr() == 'person') {
            return $this->redirectToRoute(
                'show_person_profile',
                array('slug' => $user->getSlug())
            );
        } elseif ($user->getEntityDiscr() == 'organization') {
            return $this->redirectToRoute(
                'show_organization_profile',
                array('slug' => $user->getSlug())
            );
        }
    }
}
