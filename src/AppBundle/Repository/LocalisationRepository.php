<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28/04/2017
 * Time: 16:00
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Formation;

class LocalisationRepository extends EntityRepository
{
    public function findAllLocalisations($formationId)
    {

        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.formation', 'f')
            ->where('f.formationId = :formation')
            ->setParameter('formation', $formationId);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }

    public function findEtablissementLocalisations($etablissementId)
    {

        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.etablissement', 'e')
            ->where('e.etablissementId = :etab')
            ->setParameter('etab', $etablissementId);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }
}
