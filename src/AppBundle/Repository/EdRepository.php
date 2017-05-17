<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EdRepository extends EntityRepository
{
    public function getAllEcolesDoctorales($laboId)
    {
        $qb = $this->createQueryBuilder('ed')
            ->select('ed.code')
            ->leftJoin('ed.labo', 'l')
            ->where('l.laboId = :labo')
            ->setParameter('labo', $laboId);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }
}