<?php

namespace AppBundle\Services;

use AppBundle\Entity\Charity;
use Doctrine\Common\Persistence\ObjectManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class CategoryManager
{
    protected $em;
    protected $findedCharitiesOnPage;


    /**
     * CharityManager constructor.
     * @param ObjectManager $em
     * @param $findedCharitiesOnPage
     */
    public function __construct(
        ObjectManager $em,
        $findedCharitiesOnPage
    ) {
        $this->em = $em;
        $this->findedCharitiesOnPage = $findedCharitiesOnPage;
    }

    /**
     * @param $page
     * @param $itemsPerPage
     * @return null|Pagerfanta
     */
    public function getCharityListPaginated($page, $itemsPerPage)
    {
        $qb = $this->em->getRepository('AppBundle:Category')->findAllCategoriesQuery();

        if ($qb === null) {
            return null;
        }
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($itemsPerPage);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }
}