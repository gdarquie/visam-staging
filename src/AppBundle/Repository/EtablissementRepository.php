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
}

