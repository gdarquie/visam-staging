<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AxeRepository extends EntityRepository
{
    public function findAllAxe($laboId)
    {

        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->leftJoin('a.labo', 'l')
            ->where('l.laboId = :labo')
            ->setParameter('labo', $laboId);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }

}