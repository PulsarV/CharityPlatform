<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class CharityManager
{
    protected $container;
    protected $em;
    protected $finder;
    protected $menuManager;

    /**
     * CharityManager constructor.
     * @param Container $container
     * @param ObjectManager $em
     * @param TransformedFinder $finder
     * @param MenuManager $menuManager
     */
    public function __construct(Container $container, ObjectManager $em, TransformedFinder $finder, MenuManager $menuManager)
    {
        $this->container = $container;
        $this->em = $em;
        $this->finder = $finder;
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
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharities($sortMode);
                break;
            case 'user':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesByUser($filterValue, $sortMode);
                break;
            case 'category':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesByCategory($filterValue, $sortMode);
                break;
            case 'tag':
                $qb = $this->em->getRepository('AppBundle:Charity')->findAllCharitiesByTag($filterValue, $sortMode);
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

        $elasticaQuery = new \Elastica\Query\QueryString();
        $elasticaQuery->setParam('query', $searchQuery);
        $elasticaQuery->setParam('fields', array(
            'title',
            'content',
        ));
        $elasticaQuery->setDefaultOperator('AND');

        $pagerfanta = $this->finder->findPaginated($elasticaQuery);
        $pagerfanta->setMaxPerPage($this->container->getParameter('app.paginator_count_per_page'));
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }
}