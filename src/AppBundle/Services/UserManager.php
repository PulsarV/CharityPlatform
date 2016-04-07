<?php

namespace AppBundle\Services;

use AppBundle\Entity\Organization;
use AppBundle\Entity\Person;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    protected $uploadableManager;
    protected $mailSender;

    /**
     * UserManager constructor.
     * @param $em
     */
    public function __construct(
        UploadableManager $uploadableManager,
        EmailSender $mailSender
    ) {
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

    protected function setTmpCode(User $user)
    {
        $user->setTemporaryPassword(md5(uniqid(rand(), true)));

        return http_build_query(array('tid' => $user->getTemporaryPassword()));
    }
}