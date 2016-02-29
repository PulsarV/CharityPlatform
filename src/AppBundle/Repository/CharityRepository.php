<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CharityRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class CharityRepository extends EntityRepository
{
    public function findAllCharities($sortMode)
    {
        $dql = "SELECT c
                FROM AppBundle:Charity c
                ORDER BY c.createdAt DESC";

        return $this->getEntityManager()->createQuery($dql);
    }
}
