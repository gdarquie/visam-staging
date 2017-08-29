<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AxeRepository extends EntityRepository
{
    public function findAllAxe($id)
    {

        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->leftJoin('a.labo', 'l')
            ->where('l.id = :labo')
            ->setParameter('labo', $id);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }

}