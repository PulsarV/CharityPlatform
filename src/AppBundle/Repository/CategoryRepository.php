<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    public function findAllCategories()
    {
        $dql = "SELECT c
                FROM AppBundle:Category c
                ORDER BY c.title ASC";

        return $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();
    }

    public function findAllCategoriesQuery()
    {
        $dql = "SELECT c
                FROM AppBundle:Category c
                ORDER BY c.title ASC";

        return $this->getEntityManager()
            ->createQuery($dql);
    }
}
