<?php
namespace AppBundle\Form\Common;

use Symfony\Component\Validator\Constraints as Assert;

class FindCharityModel
{
    /**
     * @Assert\NotBlank(message="Wrong search criteria")
     */
    private $criteria;
    /**
     * @Assert\NotBlank(message="empty_search")
     * @Assert\Type(type="string", message="Wrong search!")
     */
    private $searchQuery;

    /**
     * FindCharityModel constructor.
     * @param $criteria
     */
    public function __construct($criteria = 'title')
    {
        $this->criteria = $criteria;
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param mixed $criteria
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }

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
