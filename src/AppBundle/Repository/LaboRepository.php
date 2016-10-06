<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LaboRepository extends EntityRepository
{
    public function findAllLabos(){

        $qb = $this->createQueryBuilder('labo')
            ->addOrderBy('labo.nom', 'ASC');

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }
}
