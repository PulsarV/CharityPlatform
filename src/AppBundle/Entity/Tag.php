<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z0-9]+$",
     *     message="Tag can contain only numbers and letters."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Tag can not be less than {{ limit }}!",
     *      maxMessage = "Tag can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $tagName;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Charity", inversedBy="tags", cascade={"persist"}, orphanRemoval=true)
     */
    private $charities;

    /**
     * @Gedmo\Slug(fields={"tagName"})
     * @ORM\Column(length=64, unique=true)
     */
    private $slug;

    public function __construct()
    {
        $this->charities = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * @param mixed $tagName
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getCharities()
    {
        return $this->charities;
    }

    /**
     * @param Charity $charity
     */
    public function addCharity(Charity $charity)
    {
        $this->charities->add($charity);
    }

    /**
     * @param Charity $charity
     */
    public function removeCharity(Charity $charity)
    {
        $this->charities->removeElement($charity);
    }
}