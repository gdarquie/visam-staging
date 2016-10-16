<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{

    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('tag')
            ->orderBy('tag.nom', 'ASC');
    }
}

