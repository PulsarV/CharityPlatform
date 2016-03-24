<?php
namespace AppBundle\Form\Common;

use Symfony\Component\Validator\Constraints as Assert;

class FindCharityModel
{
    /**
     * @Assert\NotBlank(message="empty_search")
     * @Assert\Type(type="string", message="Wrong search!")
     */
    private $title;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
