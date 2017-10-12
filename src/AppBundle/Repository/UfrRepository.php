<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UfrRepository extends EntityRepository
{
    public function getAllNom()
    {
        return $this
            ->createQueryBuilder('ufr')
            ->select('ufr.ufrId, ufr.nom')
            ->getQuery()
            ->getArrayResult();
    }

    /***
     * @param $value
     * @return obj
     *
     */
    public function getUfrByNom($value){

        return $this->findOneBy(array('nom' => $value));
    }
}

