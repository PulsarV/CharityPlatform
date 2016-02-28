<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity("title")
 * @ORM\Table(name="category")
 */
class Category
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
     * @Assert\Length(
     *      min = 4,
     *      max = 60,
     *      minMessage = "Category title can not be less than {{ limit }}!",
     *      maxMessage = "Category title can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Charity", mappedBy="category", cascade={"persist"}, orphanRemoval=true)
     */
    private $charities;


    /**
     * @Assert\Type(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      minMessage = "Importance can not be less than {{ limit }}!",
     *      maxMessage = "Importance can not be more than {{ limit }}!"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="integer", length=20)
     */
    private $importance;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="categories", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinTable(name="categories_users")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="followCategories", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinTable(name="followCategories_followedByUsers")
     */
    private $followedByUsers;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=64, unique=true)
     */
    private $slug;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->followedByUsers = new ArrayCollection();
        $this->charities = new ArrayCollection();
        $this->importance = 0;
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

    /**
     * @return mixed
     */
    public function getImportance()
    {
        return $this->importance;
    }

    /**
     * @param mixed $importance
     */
    public function setImportance($importance)
    {
        $this->importance = $importance;
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

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users->add($user);
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * @return mixed
     */
    public function getFollowedByUsers()
    {
        return $this->followedByUsers;
    }

    /**
     * @param User $user
     */
    public function addFolloweByUser(User $user)
    {
        $this->followedByUsers->add($user);
    }

    /**
     * @param User $user
     */
    public function removeFolloweByUser(User $user)
    {
        $this->followedByUsers->removeElement($user);
    }
}