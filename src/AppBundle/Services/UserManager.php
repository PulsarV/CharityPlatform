<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserManager
{
    const STANDARTAVATAR = 'standart_avatar.gif';

    protected $em;
    protected $uploadableManager;
    protected $mailSender;
    protected $encoder;

    /**
     * UserManager constructor.
     * @param $em
     */
    public function __construct(
        EntityManager $em,
        UploadableManager $uploadableManager,
        EmailSender $mailSender,
        UserPasswordEncoder $encoder
    ) {
        $this->em = $em;
        $this->uploadableManager = $uploadableManager;
        $this->mailSender = $mailSender;
        $this->encoder = $encoder;
    }

    /**
     * @param User $user
     * @param string $avatar
     * @param array $files
     */
    public function setAvatar(
        User $user,
        $avatar = self::STANDARTAVATAR,
        array $files = array('avatarFileName' => null)
    ) {
        if ($files['avatarFileName'] !== null || $user->getAvatarFileName() !== null) {
            $this->uploadableManager->markEntityToUpload($user, $user->getAvatarFileName());
        } else {
            $user->setAvatarFileName($avatar);
        }
    }

    /**
     * @param User $user
     */
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

    /**
     * @param $code
     * @return string
     */
    public function checkActivationCode($code)
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['temporaryPassword' => $code]);

        if ($user) {
            $user->setIsActive(true);
            $user->setTemporaryPassword(null);
            $this->em->flush();

            return 'activation_success';
        } else {
            return 'activation_fail';
        }
    }

    /**
     * @param User $user
     * @return mixed
     */
    protected function setTmpCode(User $user)
    {
        $user->setTemporaryPassword(md5(uniqid($user->getUsername(), true)));
        $this->em->flush();

        return $user->getTemporaryPassword();
    }

    public function recoverPassword($email)
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $email]);
        if (!$user) {
            return 'User is not registered';
        } elseif ($user->getTemporaryPassword() !== null && $user->getIsActive() == false) {
            return 'User is not activated';
        } elseif (
            $user->getFacebookId() !== null ||
            $user->getVkontakteId() !== null ||
            $user->getGoogleId() !== null
        ) {
            return 'Users from social networks doesn\'t have passwords';
        } else {
            $code = $this->setTmpCode($user);
            $this->mailSender->send(
                $this->mailSender->getSender(),
                $user->getEmail(),
                'Recover password in Online CharityPlatform',
                'AppBundle:Emails:recover.html.twig',
                array(
                    'code' => $code
                )
            );
        }

        return null;
    }

    /**
     * @param $code
     * @return string
     */
    public function checkRecoverCode($code)
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['temporaryPassword' => $code]);

        if ($user) {
            $password = uniqid($user->getSlug(), true);
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $user->setTemporaryPassword(null);
            $this->em->flush();
            $this->mailSender->send(
                $this->mailSender->getSender(),
                $user->getEmail(),
                'Activate account in Online CharityPlatform',
                'AppBundle:Emails:new-password.html.twig',
                array(
                    'code' => $code
                )
            );

            return 'recover_success';
        } else {
            return 'recover_fail';
        }
    }

    /**
     * @param $code
     * @return string
     */
    public function changePassword($password)
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['temporaryPassword' => $password]);

        if ($user) {
            $password = uniqid($user->getSlug(), true);
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $user->setTemporaryPassword(null);
            $this->em->flush();
            $this->mailSender->send(
                $this->mailSender->getSender(),
                $user->getEmail(),
                'Activate account in Online CharityPlatform',
                'AppBundle:Emails:new-password.html.twig',
                array(
                    'code' => $password
                )
            );

            return 'recover_success';
        } else {
            return 'recover_fail';
        }
    }
}