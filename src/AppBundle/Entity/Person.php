<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Person extends User
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 16,
     *      minMessage = "Organization name can not be less than {{ limit }}!",
     *      maxMessage = "Organization name can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=25)
     */
    private $firstname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 16,
     *      minMessage = "Organization name can not be less than {{ limit }}!",
     *      maxMessage = "Organization name can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=25)
     */
    private $lastname;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(
     *      type="date"
     * )
     * @ORM\Column(type="date")
     */
    private $birthday;

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