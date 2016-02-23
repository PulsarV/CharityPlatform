<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function loginAction()
    {

        return $this->render('@App/security/login.html.twig', [

        ]);
    }

    /**
     * @Route("/register", name="registration")
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request)
    {

        return $this->render('@App/security/register.html.twig', [

        ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @param Request $request
     * @return Response
     */
    public function logoutAction(Request $request)
    {

        return $this->render('@App/security/logout.html.twig', [

        ]);
    }

    /**
     * @Route("/profile/{slug}", name="show_profile_user")
     * @return Response
     */
    public function showProfileAction()
    {

        return $this->render('@App/security/profile.html.twig', [

        ]);

    }
}
