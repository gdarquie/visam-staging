<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DisciplineRepository extends EntityRepository
{

	public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('discipline')
            ->orderBy('discipline.nom', 'ASC');
    }
}
