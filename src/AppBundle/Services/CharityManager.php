<?php

namespace AppBundle\Services;

use AppBundle\Entity\Charity;
use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Form\Common\FindCharityType;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class CharityManager
{
    const STANDARTBANNER = 'standart_banner.gif';

    protected $em;
    protected $finder;
    protected $menuManager;
    protected $uploadableManager;
    protected $findedCharitiesOnPage;


    /**
     * CharityManager constructor.
     * @param ObjectManager $em
     * @param TransformedFinder $finder
     * @param MenuManager $menuManager
     * @param $findedCharitiesOnPage
     */
    public function __construct(
        ObjectManager $em,
        TransformedFinder $finder,
        MenuManager $menuManager,
        UploadableManager $uploadableManager,
        $findedCharitiesOnPage
    ) {
        $this->em = $em;
        $this->finder = $finder;
        $this->menuManager = $menuManager;
        $this->uploadableManager = $uploadableManager;
        $this->findedCharitiesOnPage = $findedCharitiesOnPage;
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
        $qb = null;
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
        if ($qb === null) {
            return null;
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
        $pagerfanta->setMaxPerPage($this->findedCharitiesOnPage);
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

    /**
     * @param Charity $charity
     * @param string $banner
     * @param array $files
     */
    public function setBanner(
        Charity $charity,
        $banner = self::STANDARTBANNER,
        array $files = array('banner' => null)
    ) {
        if ($files['banner'] !== null || $charity->getBanner() !== null) {
            $this->uploadableManager->markEntityToUpload($charity, $charity->getBanner());
        } else {
            $charity->setBanner($banner);
        }
    }

    public function addCharityComment(Charity $charity, Comment $comment, User $user)
    {
        if ($user !== null) {
            $comment->setUser($user);
        }
        $comment->setCharity($charity);
        $this->em->persist($comment);
        $this->em->flush();
    }
}