<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EtablissementRepository extends EntityRepository
{

    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('etablissement')
            ->orderBy('etablissement.nom', 'ASC');
    }

    public function createAlphabeticalQueryBuilderWhereEtab()
    {

        if(!isset($etablissement)){
            $etablissement = ['etablissement'=>1,'etablissement'=>3];
        }
        return $this->createQueryBuilder('etablissement')
            ->where('etablissement = :etablissement')
//            ->andWhere('s.id IN (:status)')
//            ->setParameter('etablissement', $etablissement)
            ->setParameters($etablissement)
            ->orderBy('etablissement.nom', 'ASC');

    }

    /***
     * @param $id, $code
     * @return boolean
     *
     */
    public function verifyEtablissementByCodeAndId($id, $code)
    {
        $etablissement = $this
            ->findOneBy(array('etablissementId' => $id, 'code' => $code));

        if (!$etablissement) {
            return false;
        }
        return true;
    }
}

