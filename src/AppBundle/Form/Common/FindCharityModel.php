<?php
namespace AppBundle\Form\Common;

use Symfony\Component\Validator\Constraints as Assert;

class FindCharityModel
{
    /**
     * @Assert\NotBlank(message="empty_search")
     * @Assert\Type(type="string", message="Wrong search!")
     */
    private $searchQuery;

    /**
     * @return mixed
     */
    public function getsearchQuery()
    {
        return $this->searchQuery;
    }

    /**
     * @param mixed $searchQuery
     */
    public function setsearchQuery($searchQuery)
    {
        $this->searchQuery = $searchQuery;
    }
}
