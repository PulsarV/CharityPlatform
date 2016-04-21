<?php
namespace AppBundle\Form\Security;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordModel
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
    protected $oldPassword;

    /**
     * @Assert\Length(
     *     min = 8,
     *     max = 32,
     *     minMessage = "Password can not be less than {{ limit }} chars",
     *     maxMessage = "Password can not be more than {{ limit }} chars"
     * )
     */
    protected $newPassword;
}