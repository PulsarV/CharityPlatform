<?php
namespace AppBundle\Form\Common;

use Symfony\Component\Validator\Constraints as Assert;

class FindCharityModel
{
    private $titleCriteria;

    private $contentCriteria;

    private $authorCriteria;

    private $categoryCriteria;

    private $tagsCriteria;

    /**
     * @Assert\NotBlank(message="empty_search")
     * @Assert\Type(type="string", message="Wrong search!")
     */
    private $searchQuery;

    /**
     * FindCharityModel constructor.
     * @param $criteria
     */
    public function __construct()
    {
        $this->titleCriteria = true;
    }

    /**
     * @return mixed
     */
    public function getTitleCriteria()
    {
        return $this->titleCriteria;
    }

    /**
     * @param mixed $titleCriteria
     */
    public function setTitleCriteria($titleCriteria)
    {
        $this->titleCriteria = $titleCriteria;
    }

    /**
     * @return mixed
     */
    public function getContentCriteria()
    {
        return $this->contentCriteria;
    }

    /**
     * @param mixed $contentCriteria
     */
    public function setContentCriteria($contentCriteria)
    {
        $this->contentCriteria = $contentCriteria;
    }

    /**
     * @return mixed
     */
    public function getAuthorCriteria()
    {
        return $this->authorCriteria;
    }

    /**
     * @param mixed $authorCriteria
     */
    public function setAuthorCriteria($authorCriteria)
    {
        $this->authorCriteria = $authorCriteria;
    }

    /**
     * @return mixed
     */
    public function getCategoryCriteria()
    {
        return $this->categoryCriteria;
    }

    /**
     * @param mixed $categoryCriteria
     */
    public function setCategoryCriteria($categoryCriteria)
    {
        $this->categoryCriteria = $categoryCriteria;
    }

    /**
     * @return mixed
     */
    public function getTagsCriteria()
    {
        return $this->tagsCriteria;
    }

    /**
     * @param mixed $tagsCriteria
     */
    public function setTagsCriteria($tagsCriteria)
    {
        $this->tagsCriteria = $tagsCriteria;
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
