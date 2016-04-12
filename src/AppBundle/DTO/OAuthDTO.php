<?php
namespace AppBundle\DTO;

use AppBundle\Entity\Person;
use AppBundle\Services\UserManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class OAuthDTO
{
    private $person;

    public function __construct(UserResponseInterface $response)
    {
        $this->person = new Person();

        $this->person->setFirstname($response->getFirstName());
        $this->person->setLastname($response->getLastName());
        $this->person->setUsername($response->getFirstName().$response->getLastName());
        $this->person->setPassword(md5($response->getFirstName().$response->getLastName()));
        $this->person->setEmail($response->getEmail());
        $this->person->setIsActive(true);
        $this->person->setAvatarFileName(UserManager::STANDARTAVATAR);
        $data = $response->getResponse();
        if (isset($data['response'])) {
            $this->person->setVkontakteId($response->getUsername());
            if (empty($data['response']['0']['bdate'])) {
                throw new \Exception('You can\'t autorize without your birthday information');
            }
            $bdate = $data['response']['0']['bdate'];
            $bdate = \DateTime::createFromFormat('j.n.Y', $bdate);
            $this->person->setBirthday($bdate->format('Y-m-d'));
        } else {
            $this->person->setFacebookId($response->getUsername());
            if (empty($data['birthday'])) {
                throw new \Exception('You can\'t autorize without your birthday information');
            }
            $bdate = $data['birthday'];
            $bdate = \DateTime::createFromFormat('m/d/Y', $bdate);
            $this->person->setBirthday($bdate->format('Y-m-d'));
        }
    }

    public function getPerson()
    {
        return $this->person;
    }
}