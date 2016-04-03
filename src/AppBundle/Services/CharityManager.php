<?php

namespace AppBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class CharityManager
{
    protected $em;
    protected $finder;
    protected $menuManager;
    protected $findedCharitiesOnPage;


    /**
     * CharityManager constructor.
     * @param ObjectManager $em
     * @param TransformedFinder $finder
     * @param MenuManager $menuManager
     * @param $findedCharitiesOnPage
     */
    public function __construct(ObjectManager $em, TransformedFinder $finder, MenuManager $menuManager, $findedCharitiesOnPage)
    {
        $this->em = $em;
        $this->finder = $finder;
        $this->menuManager = $menuManager;
        $this->findedCharitiesOnPage = $findedCharitiesOnPage;
    }

    public function configShow($param, $value)
    {
        switch($param) {
            case 'lng':
                if (in_array($value, $this->menuManager->getAvailableLanguages())) {
                    $this->menuManager->setCurrentLanguage($value);
                }
                break;
            case 'city':
                if (in_array($value, $this->menuManager->getAvailableCities())) {
                    $this->menuManager->setCurrentCity($value);
                }
                break;
        }

        return;
    }

    public function getCharityListPaginated($filterName, $filterValue, $sortMode, $page, $itemsPerPage)
    {
        if ($filterName == '') {
            new \Exception('Щось пішло не так');
        }
        if ($filterValue == '') {
            new \Exception('Щось пішло не так');
        }
        if ($sortMode == 'a') {
            $sortMode = 'ASC';
        } else if ($sortMode == 'd') {
            $sortMode = 'DESC';
        } else {
            new \Exception('Щось пішло не так');
        }
        switch($filterName) {
            case 'none':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesQuery($sortMode);
                break;
            case 'user':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesByUserQuery($filterValue, $sortMode);
                break;
            case 'category':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesByCategoryQuery($filterValue, $sortMode);
                break;
            case 'tag':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesByTagQuery($filterValue, $sortMode);
                break;
            default:
                new \Exception('Щось пішло не так');
                break;
        }
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($itemsPerPage);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }

    public function getFindCharityListPaginated($criteria, $searchQuery, $page)
    {

        if ($criteria == '') {
            new \Exception('Щось пішло не так');
        }
        if ($searchQuery == '') {
            new \Exception('Щось пішло не так');
        }
        if (!in_array($criteria, ['author', 'category', 'content', 'title'])) {
            new \Exception('Щось пішло не так');
        }

// тут повинно чимось типу switch() вибирати тип фільтру на основі $criteria

        $pagerfanta = $this->finder->findPaginated($searchQuery);
        $pagerfanta->setMaxPerPage($this->findedCharitiesOnPage);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }
}