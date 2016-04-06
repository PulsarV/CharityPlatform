<?php

namespace AppBundle\Services;

use AppBundle\Entity\Organization;
use AppBundle\Entity\Person;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    protected $em;
    protected $passwordEncoder;

    /**
     * UserManager constructor.
     * @param $em
     */
    public function __construct(ObjectManager $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createUser($userSelector, $username, $plainPassword, $email)
    {
        if ($userSelector == 'person') {
            $user = new Person();
        } elseif ($userSelector == 'organization') {
            $user = new Organization();
        } else {
            new \Exception('ERROR!!!');
        }

        $user->setUsername($username);
        $password = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        $user->setTemporaryPassword($user->getPassword());
        $user->setEmail($email);

        $this->em->persist($user);
        $this->em->flush();
    }


}