<?php
namespace AppBundle\Form\Security;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordModel
{
    //TODO: add to translations
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Не правельно введений поточний пароль."
     * )
     */
    private $oldPassword;

    /**
     * @Assert\Length(
     *     min = 8,
     *     max = 32,
     *     minMessage = "Пароль не може бути меньшим ніж {{ limit }} знаків.",
     *     maxMessage = "Пароль не може бути більшим ніж {{ limit }} знаків"
     * )
     */
    private $newPassword;

    /**
     * @return mixed
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }
}