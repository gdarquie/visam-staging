<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EquipementRepository extends EntityRepository
{
    public function getAllEquipements($id)
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e.nom')
            ->leftJoin('e.labo', 'l')
            ->where('l.id = :labo')
            ->setParameter('labo', $id);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }
}