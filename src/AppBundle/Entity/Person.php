<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person extends User
{
    /**
     * @Assert\NotBlank(
     *     message="Firstname can not be blank"
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 16,
     *      minMessage = "Firstname can not be less than {{ limit }}!",
     *      maxMessage = "Firstname can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=25)
     */
    private $firstname;

    /**
     * @Assert\NotBlank(
     *     message="Lastname can not be blank"
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 16,
     *      minMessage = "Lastname can not be less than {{ limit }}!",
     *      maxMessage = "Lastname can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=25)
     */
    private $lastname;

    /**
     * @Assert\NotBlank(
     *     message="Birthday can not be blank"
     * )
     * @Assert\Type(
     *      type="string"
     * )
     * @ORM\Column(type="string")
     */
    private $birthday;

    public function __construct()
    {
        parent::__construct();
        $this->entityDiscr = 'person';
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }
}