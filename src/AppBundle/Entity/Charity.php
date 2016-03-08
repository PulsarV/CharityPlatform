<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CharityRepository")
 * @UniqueEntity("title")
 * @ORM\Table(name="charity")
 * @Gedmo\Uploadable(pathMethod="getPath", appendNumber=true)
 */
class Charity
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /* TODO: add file upload; check VichUploaderBundle; make correct width and height */
    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\UploadableFileName
     */
    private $banner;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 10,
     *      max = 200,
     *      minMessage = "Title can not be less than {{ limit }}!",
     *      maxMessage = "Title can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=200, unique=true)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 50,
     *      minMessage = "Comment content can not be less than {{ limit }}!"
     * )
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="charities", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="primaryCharities", cascade={"persist"})
     */
    private $primaryUser;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="charities", cascade={"persist"})
     */
    private $category;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ratingCount;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $viewCount;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $needMoney;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $collectedMoney;

    /**
     * @Assert\Url(
     *    checkDNS = true,
     *    dnsMessage = "The host '{{ value }}' could not be resolved. Use the existing one."
     * )
     * @ORM\Column(type="string", length=120)
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="charity", cascade={"persist"}, orphanRemoval=true)
     */
    private $comments;


    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", mappedBy="charities", cascade={"persist"})
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CharityImage", mappedBy="charity", cascade={"persist"}, orphanRemoval=true)
     */
    private $charityImages;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=64, unique=true)
     */
    private $slug;

    /**
     * Charity constructor.
     * @param $tags
     * @param $comments
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->charityImages = new ArrayCollection();
        $this->collectedMoney = 0;
        $this->ratingCount = 0;
        $this->viewCount = 0;
        $this->isActive = true;
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
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param mixed $banner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPrimaryUser()
    {
        return $this->primaryUser;
    }

    /**
     * @param mixed $primaryUser
     */
    public function setPrimaryUser($primaryUser)
    {
        $this->primaryUser = $primaryUser;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getRatingCount()
    {
        return $this->ratingCount;
    }

    /**
     * @param mixed $ratingCount
     */
    public function setRatingCount($ratingCount)
    {
        $this->ratingCount = $ratingCount;
    }

    /**
     * @return mixed
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param mixed $viewCount
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
    }

    /**
     * @return mixed
     */
    public function getNeedMoney()
    {
        return $this->needMoney;
    }

    /**
     * @param mixed $needMoney
     */
    public function setNeedMoney($needMoney)
    {
        $this->needMoney = $needMoney;
    }

    /**
     * @return mixed
     */
    public function getCollectedMoney()
    {
        return $this->collectedMoney;
    }

    /**
     * @param mixed $collectedMoney
     */
    public function setCollectedMoney($collectedMoney)
    {
        $this->collectedMoney = $collectedMoney;
    }

    /**
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param mixed $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
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
    public function getCharityImages()
    {
        return $this->charityImages;
    }

    /**
     * @param CharityImage $charityImage
     */
    public function addCharityImage(CharityImage $charityImage)
    {
        $this->charityImages->add($charityImage);
    }

    /**
     *
     * @param CharityImage $charityImage
     */
    public function removeCharityImage(CharityImage $charityImage)
    {
        $this->charityImages->removeElement($charityImage);
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
    }

    /**
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    public function getPath()
    {
        return '/uploads/charities/'.$this->id.'/';
    }
}