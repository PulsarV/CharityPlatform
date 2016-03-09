<?php

namespace AppBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class MenuManager
{
    protected $em;
    protected $availableLanguages = [
        'en',
        'ru',
        'uk'
    ];
    protected $currentLanguage;
    protected $availableCities = [
        'Cherkasy',
        'Chernivtsi',
        'Donetsk',
        'Dnipropetrovsk',
        'Ivano-Frankivsk',
        'Kirovograd',
        'Kharkiv',
        'Kherson',
        'Khmelnytskyi',
        'Kyiv',
        'Lugansk',
        'Lviv',
        'Lutsk',
        'Mykolaiv',
        'Odesa',
        'Poltava',
        'Rivne',
        'Sevastopol',
        'Sumy',
        'Ternopil',
        'Uzhgorod',
        'Vinnytsya',
        'Zaporizhya',
        'Zhytomyr',
    ];
    protected $currentCity;

    /**
     * MenuProvider constructor.
     * @param $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
        $this->currentLanguage = 'uk';
        $this->currentCity = 'Cherkasy';
    }

    public function getPageTitle()
    {
        return 'Запити';
    }

    public function getAllCategories()
    {
        return $this->em->getRepository('AppBundle:Category')->findAll();
    }

    public function getBreadCrumbs()
    {
        return ['Головна', 'Запити',];
    }

    public function getAvailableLanguages()
    {
        return $this->availableLanguages;
    }

    public function getCurrentLanguage()
    {
        return $this->currentLanguage;
    }

    public function setCurrentLanguage($language)
    {
        return $this;
    }

    public function getAvailableCities()
    {
        return $this->availableCities;
    }

    public function getCurrentCity()
    {
        return $this->currentCity;
    }

    public function setCurrentCity($city)
    {
        return $this;
    }

    public function getImportantCharities()
    {
        return $this->em->getRepository('AppBundle:Charity')->findTopImportantCharities(5);
    }

    public function getActiveCharities()
    {
        return $this->em->getRepository('AppBundle:Charity')->findTopActiveCharities(5);
    }

    public function getCompletedCharities()
    {
        return $this->em->getRepository('AppBundle:Charity')->findTopCompletedCharities(5);
    }

    public function getTagCloudElements()
    {
        return $this->em->getRepository('AppBundle:Tag')->findAllTagsByPopularity();
    }
}