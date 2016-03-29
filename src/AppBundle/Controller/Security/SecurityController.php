<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\Organization;
use AppBundle\Entity\Person;
use AppBundle\Form\Security\LoginModel;
use AppBundle\Form\Security\RegisterOrganizationType;
use AppBundle\Form\Security\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Security\RegisterPersonType;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
        $loginForm = $this->createForm(LoginType::class, new LoginModel(true), [
            'action' => $this->generateUrl('login_check')
        ]);

        return [
            'login_form' => $loginForm->createView()
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
//                $password = $this->get('security.password_encoder')
//                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($user->getPlainPassword());

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                if ($user->getAvatarFileName() !== null) {
                    $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                    $uploadableManager->markEntityToUpload($user, $user->getAvatarFileName());
                } else {
                    $user->setAvatarFileName('standart_avatar.gif');
                }
                $em->flush();

                return $this->redirectToRoute(
                    "registration_person"
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
//                $password = $this->get('security.password_encoder')
//                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($user->getPlainPassword());

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                if ($user->getAvatarFileName() !== null) {
                    $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                    $uploadableManager->markEntityToUpload($user, $user->getAvatarFileName());
                } else {
                    $user->setAvatarFileName('standart_avatar.gif');
                }
                $em->flush();

                return $this->redirectToRoute(
                    "registration_organization"
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
}
