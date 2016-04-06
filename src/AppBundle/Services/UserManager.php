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
    protected $em;
    protected $passwordEncoder;
    protected $uploadableManager;

    /**
     * UserManager constructor.
     * @param $em
     */
    public function __construct(
        ObjectManager $em,
        UserPasswordEncoderInterface $passwordEncoder,
        UploadableManager $uploadableManager
    ) {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->uploadableManager = $uploadableManager;
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
}