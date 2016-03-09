<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Organization;
use AppBundle\Entity\Person;
use AppBundle\Form\RegisterOrganizationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\RegisterPersonType;

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
     * @Route("/register-person", name="registration_person")
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
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                $uploadableManager->markEntityToUpload($user, $user->getAvatarFileName());
                $em->flush();

                return $this->redirectToRoute(
                    "registration_person"
                );
            }
        }
        return $this->render('@App/security/register-person.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/register-organization", name="registration_organization")
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
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                $uploadableManager->markEntityToUpload($user, $user->getAvatarFileName());
                $em->flush();

                return $this->redirectToRoute(
                    "registration_organization"
                );
            }
        }
        return $this->render('@App/security/register-organization.html.twig', [
            'form' => $form->createView()
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
