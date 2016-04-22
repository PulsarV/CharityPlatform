<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\Organization;
use AppBundle\Entity\Person;
use AppBundle\Entity\User;
use AppBundle\Form\Security\ChangePasswordModel;
use AppBundle\Form\Security\ChangePasswordType;
use AppBundle\Form\Security\LoginModel;
use AppBundle\Form\Security\RecoverPasswordType;
use AppBundle\Form\Security\RegisterOrganizationType;
use AppBundle\Form\Security\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Method({"GET", "POST"})
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
     * @Method({"GET", "POST"})
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

    /**
     * @Route("/recover", name="recover_password")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return Response
     */
    public function recoverPasswordAction(Request $request)
    {
        $form = $this->createForm(RecoverPasswordType::class);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $email = $form->get('email')->getData();
                $userManager = $this->get('app.user_manager');
                $result = $userManager->recoverPassword($email);

                if($result) {
                    return [
                        'error' => $result,
                        'form' => $form->createView(),
                    ];
                } else {
                    return $this->redirectToRoute(
                        'recover_complete'
                    );
                }
            }
        }
        return [
            'error' => null,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/complete-recover", name="recover_complete")
     * @Method({"GET"})
     * @Template()
     */
    public function recoverCompleteAction(Request $request)
    {
        return [

        ];
    }

    /**
     * @Route("/recovering/{code}", name="profile_recovering")
     * @return Response
     */
    public function recoveringAction($code)
    {
        $userManager = $this->get('app.user_manager');
        $redirect = $userManager->checkRecoverCode($code);

        return $this->redirectToRoute($redirect);
    }

    /**
     * @Route("/recover-success", name="recover_success")
     * @Template()
     * @return Response
     */
    public function recoverSuccessAction()
    {
        return [];
    }

    /**
     * @Route("/recover-fail", name="recover_fail")
     * @Template()
     * @return Response
     */
    public function recoverFailAction()
    {
        return [];
    }

    /**
     * @Route("/change-passwd", name="change_password")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return Response
     */
    public function changePasswordAction(Request $request)
    {
        $changePasswordModel = new ChangePasswordModel();
        $form = $this->createForm(ChangePasswordType::class, $changePasswordModel);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $password = $form->get('newPassword')->getData();
                $userManager = $this->get('app.user_manager');
                $result = $userManager->changePassword(
                    $this->getUser(),
                    $password
                );

                if ($result) {
                    return [
                        'error' => $result,
                        'form' => $form->createView(),
                    ];
                } else {
                    return $this->redirectToRoute(
                        'change-passwd_success'
                    );
                }
            }
        }
        return [
            'error' => null,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/change-passwd-success", name="change-passwd_success")
     * @Template()
     * @return Response
     */
    public function changePasswdSuccessAction()
    {
        return [];
    }

    /**
     * @Route("/users/{slug}/block", name="block_user")
     * @ParamConverter(
     *      "user",
     *      class="AppBundle:User",
     *      options={"mapping": {"slug": "slug"}}
     * )
     */
    public function blockUserAction(User $user)
    {
        $user->setIsActive(!$user->getIsActive());
        $this->getDoctrine()->getManager()->flush();

        if ($user->getEntityDiscr() == 'person') {
            return $this->redirectToRoute('show_person_profile', array(
                'slug' => $user->getSlug()
            ));
        } elseif ($user->getEntityDiscr() == 'organization') {
            return $this->redirectToRoute('show_organization_profile', array(
                'slug' => $user->getSlug()
            ));
        }
    }
}
