<?php

namespace AppBundle\Services;

use AppBundle\Entity\Organization;
use AppBundle\Entity\Person;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    protected $em;
    protected $uploadableManager;
    protected $mailSender;

    /**
     * UserManager constructor.
     * @param $em
     */
    public function __construct(
        EntityManager $em,
        UploadableManager $uploadableManager,
        EmailSender $mailSender
    ) {
        $this->em = $em;
        $this->uploadableManager = $uploadableManager;
        $this->mailSender = $mailSender;
    }

    public function setAvatar(
        User $user,
        $avatar = 'standart_avatar.gif',
        array $files = array('avatarFileName' => null)
    ) {
        if ($files['avatarFileName'] !== null || $user->getAvatarFileName() !== null) {
            $this->uploadableManager->markEntityToUpload($user, $user->getAvatarFileName());
        } else {
            $user->setAvatarFileName($avatar);
        }
    }

    public function sendRegistrationCode(User $user)
    {
        $code = $this->setTmpCode($user);
        $this->mailSender->send(
            $this->mailSender->getSender(),
            $user->getEmail(),
            'Activate account in Online CharityPlatform',
            'AppBundle:Emails:activation-email.html.twig',
            array(
                'code' => $code
            )

        );
    }

    public function checkActivationCode($code)
    {
        $user = $this->em->getRepository('AppBundle:Person')->findOneBy(['temporaryPassword' => $code]);
        if (!$user) {
            $user = $this->em->getRepository('AppBundle:Organization')->findOneBy(['temporaryPassword' => $code]);
        }

        if ($user) {
            $user->setIsActive(true);
            $user->setTemporaryPassword(null);
            $this->em->flush();

            return 'activation_success';
        } else {
            return 'activation_fail';
        }
    }

    protected function setTmpCode(User $user)
    {
        $user->setTemporaryPassword(md5(uniqid($user->getUsername(), true)));
        $this->em->flush();

        return $user->getTemporaryPassword();
    }
}