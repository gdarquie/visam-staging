<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EquipementRepository extends EntityRepository
{
    public function getAllEquipements($laboId)
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e.nom')
            ->leftJoin('e.labo', 'l')
            ->where('l.laboId = :labo')
            ->setParameter('labo', $laboId);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }
}