<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FormationRepository extends EntityRepository
{
    public function findAllFormationsApi()
    {

        $qb = $this->createQueryBuilder('f')
            ->join('f.discipline', 'd')
            ->select('f, d.nom as discipline') //une seule discipline est gardé pour l'instant
            ->addOrderBy('f.nom', 'ASC');


        $query = $qb->getQuery()->getArrayResult();

        return $query;

    }
}

