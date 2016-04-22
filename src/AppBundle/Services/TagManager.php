<?php

namespace AppBundle\Services;

use AppBundle\Entity\Charity;
use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Form\Form;

class TagManager
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
    public function getTagListPaginated($page, $itemsPerPage)
    {
        $qb = $this->em->getRepository('AppBundle:Tag')->findAllTagsQuery();

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