<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Etablissement;

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

    public function findAllFormations(Etablissement $etablissement)
    {
        $qb = $this->createQueryBuilder('f')
            ->select('f')
            ->where('e.etablissement = :etab')
            ->setParameter('etab', $etablissement);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }
}

