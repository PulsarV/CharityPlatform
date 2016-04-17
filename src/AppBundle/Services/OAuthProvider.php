<?php
namespace AppBundle\Services;

use AppBundle\DTO\OAuthDTO;
use Doctrine\Bundle\DoctrineBundle\Registry;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use AppBundle\Entity\Person;
use Doctrine\ORM\QueryBuilder;

class OAuthProvider extends OAuthUserProvider
{
    protected $session;
    protected $doctrine;
    protected $admins;

    public function __construct($session, Registry $doctrine)
    {
        $this->session = $session;
        $this->doctrine = $doctrine;
    }

    public function loadUserByUsername($username)
    {
        $em = $this->doctrine->getManager()->getRepository("AppBundle:Person");
        $result = $em->loadUserBySocialId($username);

        if ($result) {
            return $result;
        } else {
            return new Person();
        }
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $social_id = $response->getUsername();
        $em = $this->doctrine->getManager();
        $result = $em->getRepository("AppBundle:Person")->loadUserBySocialId($social_id);

        if (!$result) {
            $dto = new OAuthDTO($response);
            $person = $dto->getPerson();
            $em->persist($person);
            $em->flush();
        }

        return $this->loadUserByUsername($response->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'AppBundle\\Entity\\Person';
    }
}