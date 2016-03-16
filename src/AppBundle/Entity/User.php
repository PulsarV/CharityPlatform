<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"person" = "Person", "organization" = "Organization"})
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 * @Gedmo\Uploadable(
 *      pathMethod="getPath",
 *      appendNumber=true,
 *      filenameGenerator="SHA1",
 *      allowedTypes="image/jpeg,image/jpg,image/png,image/x-png"
 * )
 */
abstract class User implements  UserInterface, \Serializable
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(
     *      min = 4,
     *      max = 16,
     *      minMessage = "Username can not be less than {{ limit }}!",
     *      maxMessage = "Username can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(max = 4096)
     */
    private $plainPassword;

    /**
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Email()
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\UploadableFileName
     */
    private $avatarFileName;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=60)
     */
    private $role;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bankDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;


    /**
     * @Assert\Type(type="string")
     * @Assert\Length(
     *      min = 10,
     *      max = 20,
     *      minMessage = "Phone number can not be less than {{ limit }}!",
     *      maxMessage = "Phone number can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", mappedBy="users", cascade={"persist"}, orphanRemoval=true)
     */
    private $categories;


    /**
     * @Assert\Type(
     *     type="bool",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @ORM\Column(type="boolean")
     */
    private $showOtherCategories;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", mappedBy="followedByUsers", cascade={"persist"}, orphanRemoval=true)
     */
    private $followCategories;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Charity", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     */
    private $charities;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Charity", mappedBy="primaryUser", cascade={"persist"}, orphanRemoval=true)
     */
    private $primaryCharities;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     */
    private $comments;


    /**
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean")
     */
    private $isActive;


    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $cautionCount;

    /**
     * @Gedmo\Slug(fields={"username"})
     * @ORM\Column(length=64, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $entityDiscr;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->followCategories = new ArrayCollection();
        $this->charities = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->primaryCharities = new ArrayCollection();
        $this->isActive = false;
        $this->cautionCount = 0;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

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

    /**
     * @return mixed
     */
    public function getAvatarFileName()
    {
        return $this->avatarFileName;
    }

    /**
     * @param mixed $avatarFileName
     */
    public function setAvatarFileName($avatarFileName)
    {
        $this->avatarFileName = $avatarFileName;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getBankDetails()
    {
        return $this->bankDetails;
    }

    /**
     * @param mixed $bankDetails
     */
    public function setBankDetails($bankDetails)
    {
        $this->bankDetails = $bankDetails;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getShowOtherCategories()
    {
        return $this->showOtherCategories;
    }

    /**
     * @param mixed $showOtherCategories
     */
    public function setShowOtherCategories($showOtherCategories)
    {
        $this->showOtherCategories = $showOtherCategories;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getCautionCount()
    {
        return $this->cautionCount;
    }

    /**
     * @param mixed $cautionCount
     */
    public function setCautionCount($cautionCount)
    {
        $this->cautionCount = $cautionCount;
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
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories->add($category);
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
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
    public function getPrimaryCharities()
    {
        return $this->primaryCharities;
    }

    /**
     * @param Charity $charity
     */
    public function addPrimaryCharity(Charity $charity)
    {
        $this->primaryCharities->add($charity);
    }

    /**
     * @param Charity $charity
     */
    public function removePrimaryCharity(Charity $charity)
    {
        $this->primaryCharities->removeElement($charity);
    }

    /**
     * @return mixed
     */
    public function getFollowCategories()
    {
        return $this->followCategories;
    }

    /**
     * @param Category $category
     */
    public function addFollowCategory(Category $category)
    {
        $this->followCategories->add($category);
    }

    /**
     * @param Category $category
     */
    public function removeFollowCategory(Category $category)
    {
        $this->followCategories->removeElement($category);
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
    }
    /**
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * @return mixed
     */
    public function getEntityDiscr()
    {
        return $this->entityDiscr;
    }

    /**
     * @param mixed $entityDiscr
     */
    public function setEntityDiscr($entityDiscr)
    {
        $this->entityDiscr = $entityDiscr;
    }

    public function getPath()
    {
        return __DIR__ . '/../../../web/uploads/users/';
    }

    public function getRoles()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized);
    }
}