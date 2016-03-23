<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\Organization;
use AppBundle\Entity\Person;
use AppBundle\Form\Security\RegisterOrganizationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Security\RegisterPersonType;

class SecurityController extends Controller
{
    /**
     * @Template()
     */
    public function showEmbeddedLoginFormAction()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('login_check'))
            ->add('username', TextType::class, ['required' => true])
            ->add('password', PasswordType::class, ['required' => true])
            ->add('remember_me', CheckboxType::class, ['required' => false])
            ->getForm();
        return [
            'login_form' => $form->createView()
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
                    $user->setAvatarFileName('no_avatar.gif');
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
                    $user->setAvatarFileName('no_avatar.gif');
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
