<?php

namespace AppBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class CharityManager
{
    const CHARITIES_PER_PAGE = 5;

    protected $em;
    protected $menuManager;

    /**
     * CharityManager constructor.
     * @param $menuManager
     */
    public function __construct(ObjectManager $em, MenuManager $menuManager)
    {
        $this->em = $em;
        $this->menuManager = $menuManager;
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

    public function getCharityListPaginated($filtername, $filtervalue, $sortmode, $page)
    {
        if ($filtervalue == '') {
            new \Exception('Щось пішло не так');
        }
        if ($sortmode == 'a') {
            $sortmode = 'ASC';
        } else if ($sortmode == 'd') {
            $sortmode = 'DESC';
        } else {
            new \Exception('Щось пішло не так');
        }
        switch($filtername) {
            case 'none':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharities($sortmode);
                break;
            case 'user':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesByUser($filtervalue, $sortmode);
                break;
            case 'category':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesByCategory($filtervalue, $sortmode);
                break;
            case 'tag':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesByTag($filtervalue, $sortmode);
                break;
            default:
                new \Exception('Щось пішло не так');
                break;
        }
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(self::CHARITIES_PER_PAGE);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }
}