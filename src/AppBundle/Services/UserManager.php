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

    public function createUser($userSelector, $username, $plainPassword, $email)
    {
        if ($userSelector == 'person') {
            $user = new Person();
        } elseif ($userSelector == 'organization') {
            $user = new Organization();
        } else {
            throw new \Exception('Wrong parametrs for the creating user.');
        }

        $user->setUsername($username);
        $password = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        $user->setTemporaryPassword($user->getPassword());
        $user->setEmail($email);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function setAvatar(User $user, $avatar = 'standart_avatar.gif', array $files = array())
    {
        if ($files['avatarFileName'] !== null || $user->getAvatarFileName() !== null) {
            $this->uploadableManager->markEntityToUpload($user, $user->getAvatarFileName());
        } else {
            $user->setAvatarFileName($avatar);
        }
    }
}