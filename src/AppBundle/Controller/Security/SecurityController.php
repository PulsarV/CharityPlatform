<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\Organization;
use AppBundle\Entity\Person;
use AppBundle\Form\Security\LoginModel;
use AppBundle\Form\Security\RegisterOrganizationType;
use AppBundle\Form\Security\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Security\RegisterPersonType;
use AppBundle\Form\Security\RegistrationType;

class SecurityController extends Controller
{
    /**
     * @Template()
     */
    public function loginAction()
    {
        $loginForm = $this->createForm(LoginType::class, new LoginModel(true), [
            'action' => $this->generateUrl('login_check')
        ]);

        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        return [
            'login_form' => $loginForm->createView(),
            'error' => $error
        ];
    }

    /**
     * @Template()
     */
    public function embeddedLoginFormAction()
    {
        $loginForm = $this->createForm(LoginType::class, new LoginModel(true), [
            'action' => $this->generateUrl('login_check')
        ]);

        return [
            'login_form' => $loginForm->createView()
        ];
    }

    /**
     * @Route("/registration", name="registration")
     * @Method({"GET"})
     * @Template()
     */
    public function registrationAction(Request $request)
    {
        return [

        ];
    }

    /**
     * @Route("/complete-registration", name="registration_complete")
     * @Method({"GET"})
     * @Template()
     */
    public function registrationCompleteAction(Request $request)
    {
        return [

        ];
    }

    /**
     * @Route("/register-person", name="registration_person")
     * @Template()
     * @param Request $request
     * @return Response
     */
    public function registerPersonAction(Request $request)
    {
        $user = new Person();
        $form = $this->createForm(RegisterPersonType::class, $user);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                $userManager = $this->get('app.user_manager');

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $userManager->setAvatar($user);
                $em->flush();
                $userManager->sendRegistrationCode($user);

                return $this->redirectToRoute(
                    "registration_complete"
                );
            }
        }
        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/register-organization", name="registration_organization")
     * @Template()
     * @param Request $request
     * @return Response
     */
    public function registerOrganizationAction(Request $request)
    {
        $user = new Organization();
        $form = $this->createForm(RegisterOrganizationType::class, $user);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                $userManager = $this->get('app.user_manager');

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $userManager->setAvatar($user);
                $em->flush();
                $userManager->sendRegistrationCode($user);

                return $this->redirectToRoute(
                    "registration_complete"
                );
            }
        }
        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/profile/{slug}", name="show_profile_user")
     * @Template()
     * @return Response
     */
    public function showProfileAction()
    {

        return [

        ];

    }

    /**
     * @Route("/activation/{code}", name="profile_activation")
     * @return Response
     */
    public function activationAction($code)
    {
        $userManager = $this->get('app.user_manager');
        $redirect = $userManager->checkActivationCode($code);

        return $this->redirectToRoute($redirect);
    }

    /**
     * @Route("/activation-success", name="activation_success")
     * @Template()
     * @return Response
     */
    public function activationSuccessAction()
    {
        return [];
    }

    /**
     * @Route("/activation-fail", name="activation_fail")
     * @Template()
     * @return Response
     */
    public function activationFailAction()
    {
        return [];
    }
}
