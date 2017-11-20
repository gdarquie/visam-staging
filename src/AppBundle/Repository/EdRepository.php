<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EdRepository extends EntityRepository
{
    public function getAllEcolesDoctorales($id)
    {
        $qb = $this->createQueryBuilder('ed')
            ->select('ed.code')
            ->leftJoin('ed.labo', 'l')
            ->where('l.id = :labo')
            ->setParameter('labo', $id);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }
}