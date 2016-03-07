<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
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
     * @Route("/register", name="registration")
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request)
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
                    "registration"
                );
            }
        }
        return $this->render('@App/security/register.html.twig', [
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
