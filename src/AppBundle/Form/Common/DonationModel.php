<?php

namespace AppBundle\Form\Common;

use Symfony\Component\Validator\Constraints as Assert;

class DonationModel
{
    /**
     * @Assert\NotBlank(message="empty_search")
     * @Assert\Range(min=10)
     * @Assert\Type(type="integer")
     */
    private $donation;

    /**
     * @return mixed
     */
    public function getDonation()
    {
        return $this->donation;
    }

    /**
     * @param mixed $donation
     */
    public function setDonation($donation)
    {
        $this->donation = $donation;
    }
}