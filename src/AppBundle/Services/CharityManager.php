<?php

namespace AppBundle\Services;

use AppBundle\Form\Common\FindCharityType;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Form\Form;

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

    /**
     * @param $param
     * @param $value
     */
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

    /**
     * @param $filterName
     * @param $filterValue
     * @param $sortMode
     * @param $page
     * @param $itemsPerPage
     * @return Pagerfanta
     */
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

    /**
     * @param $criteria
     * @param $searchQuery
     * @param $page
     * @return Pagerfanta
     */
    public function getFindCharityListPaginated($criteria, $searchQuery, $page)
    {
        $elasticaQuery = new \Elastica\Query\QueryString();
        $elasticaQuery->setParam('query', $searchQuery);
        $elasticaQuery->setDefaultOperator('AND');

        $fieldsArray = explode('-', $criteria);
        $fieldsArray = str_replace('user', 'user.username', $fieldsArray);
        $fieldsArray = str_replace('category', 'category.title', $fieldsArray);
        $fieldsArray = str_replace('tags', 'tags.tagName', $fieldsArray);
        $elasticaQuery->setParam('fields', $fieldsArray);

        $pagerfanta = $this->finder->findPaginated($elasticaQuery);
        $pagerfanta->setMaxPerPage($this->container->getParameter('app.paginator_count_per_page'));
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }


    /**
     * @param Form $form
     * @return string
     */
    public function generateCriteria(Form $form)
    {
        $criteriaArray = array('title');

        if ($form->get('contentCriteria')->getData()) {
            $criteriaArray[] = 'content';
        }
        if ($form->get('authorCriteria')->getData()) {
            $criteriaArray[] = 'user';
        }
        if ($form->get('categoryCriteria')->getData()) {
            $criteriaArray[] = 'category';
        }
        if ($form->get('tagsCriteria')->getData()) {
            $criteriaArray[] = 'tags';
        }

        return implode('-', $criteriaArray);
    }
}