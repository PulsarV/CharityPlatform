<?php

namespace AppBundle\Form\Security;

use Symfony\Component\Validator\Constraints as Assert;

class LoginModel
{
    /**
     * @Assert\NotBlank(message="Username can not be empty")
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Username can not be empty")
     */
    private $password;

    /**
     * @var boolean
     */
    private $rememberMe;

    /**
     * FindCharityModel constructor.
     * @param bool $rememberMe
     */
    public function __construct($rememberMe)
    {
        $this->rememberMe = $rememberMe;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return boolean
     */
    public function isRememberMe()
    {
        return $this->rememberMe;
    }

    /**
     * @param boolean $rememberMe
     */
    public function setRememberMe($rememberMe)
    {
        $this->rememberMe = $rememberMe;
    }
}
