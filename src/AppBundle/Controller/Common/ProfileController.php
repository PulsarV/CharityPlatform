<?php

namespace AppBundle\Controller\Common;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
