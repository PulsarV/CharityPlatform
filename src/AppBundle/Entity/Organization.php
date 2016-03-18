<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganizationRepository")
 */
class Organization extends User
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      max = 40,
     *      minMessage = "Organization name can not be less than {{ limit }}!",
     *      maxMessage = "Organization name can not be more than {{ limit }}!"
     * )
     * @ORM\Column(type="string", length=40, unique=true)
     */
    private $organizationName;

    /**
     * @ORM\Column(type="text")
     */
    private $organizationDocuments;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $activityProfile;

    /**
     * @Assert\Url(
     *    checkDNS = true,
     *    dnsMessage = "The host '{{ value }}' could not be resolved. Use the existing one."
     * )
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    private $website;

    public function __construct()
    {
        parent::__construct();
        $this->entityDiscr = 'organization';
    }

    /**
     * @return mixed
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * @param mixed $organizationName
     */
    public function setOrganizationName($organizationName)
    {
        $this->organizationName = $organizationName;
    }

    /**
     * @return mixed
     */
    public function getOrganizationDocuments()
    {
        return $this->organizationDocuments;
    }

    /**
     * @param mixed $organizationDocuments
     */
    public function setOrganizationDocuments($organizationDocuments)
    {
        $this->organizationDocuments = $organizationDocuments;
    }

    /**
     * @return mixed
     */
    public function getActivityProfile()
    {
        return $this->activityProfile;
    }

    /**
     * @param mixed $activityProfile
     */
    public function setActivityProfile($activityProfile)
    {
        $this->activityProfile = $activityProfile;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }
}