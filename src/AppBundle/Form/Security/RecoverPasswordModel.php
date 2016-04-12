<?php

namespace AppBundle\Form\Security;

use Symfony\Component\Validator\Constraints as Assert;

class RecoverPasswordModel
{
    /**
     * @Assert\NotBlank(message="Username can not be empty")
     * @Assert\Email(
     *     groups={"registration"},
     *     message = "The email '{{ value }}' is not a valid email",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}