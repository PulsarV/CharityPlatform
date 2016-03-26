<?php
namespace AppBundle\Form\Common;

use Symfony\Component\Validator\Constraints as Assert;

class FindCharityModel
{
    /**
     * @Assert\NotBlank(message="empty_search")
     * @Assert\Type(type="string", message="Wrong search!")
     */
    private $searchRequest;

    /**
     * @return mixed
     */
    public function getSearchRequest()
    {
        return $this->searchRequest;
    }

    /**
     * @param mixed $title
     */
    public function setSearchRequest($searchRequest)
    {
        $this->searchRequest = $searchRequest;
    }
}
