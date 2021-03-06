<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CharityRepository")
 * @UniqueEntity("title")
 * @ORM\Table(name="charity")
 * @Gedmo\Uploadable(
 *      pathMethod="getPath",
 *      appendNumber=true,
 *      filenameGenerator="SHA1",
 *      allowedTypes="image/jpeg,image/jpg,image/png,image/x-png,image/gif"
 * )
 * @ORM\HasLifecycleCallbacks
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @Assert\NotBlank()
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
     * @Assert\Range(
     *      min = 200
     * )
     * @ORM\Column(type="integer")
     */
    private $needMoney;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\Range(
     *      min = 0,
     * )
     * @ORM\Column(type="integer", nullable=true)
     */
    private $collectedMoney;

    /**
     * @Assert\Url(
     *    checkDNS = true,
     *    dnsMessage = "The host '{{ value }}' could not be resolved. Use the existing one."
     * )
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="charity", cascade={"persist"}, orphanRemoval=true)
     */
    private $comments;


    /**
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean")
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
     * @var ArrayCollection
     */
    private $uploadedFiles;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=64, unique=true)
     */
    private $slug;

    /**
     * Charity constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->charityImages = new ArrayCollection();
        $this->uploadedFiles = new ArrayCollection();
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

    /**
     * @return ArrayCollection
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }
    /**
     * @param ArrayCollection $uploadedFiles
     */
    public function setUploadedFiles($uploadedFiles)
    {
        $this->uploadedFiles = $uploadedFiles;
    }

    public function getPath()
    {
        return __DIR__ . '/../../../web/uploads/charities/';
    }

    /**
     * @ORM\PreFlush()
     */
    public function upload()
    {
        //TODO: add file limit
        /** @var UploadedFile $uploadedFile */
        if(!empty($this->uploadedFiles)) {
            foreach($this->uploadedFiles as $uploadedFile) {
                if ($uploadedFile !== null) {
                    $file = new CharityImage();

                    $path = sha1(uniqid(mt_rand(), true)).'.'.$uploadedFile->guessExtension();
                    $file->setPath($path);
                    $file->setSize($uploadedFile->getClientSize());
                    $file->setName($uploadedFile->getClientOriginalName());

                    $uploadedFile->move($this->getPath(), $path);

                    $this->getCharityImages()->add($file);
                    $file->setCharity($this);

                    unset($uploadedFile);
                }
            }
        }
    }
}