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

    public function getAllNom()
    {
        return $this
            ->createQueryBuilder('tag')
            ->select('tag.tagId, tag.nom')
            ->getQuery()
            ->getArrayResult();
    }


    public function getAllTagsForFormation($id)
    {
        $qb = $this->createQueryBuilder('tag')
            ->select('tag.nom')
            ->leftJoin('tag.formation', 'f')
            ->where('f.id = :formation')
            ->setParameter('formation', $id);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }

    public function getAllTagsForLabo($id)
    {
        $qb = $this->createQueryBuilder('tag')
            ->select('tag.nom')
            ->leftJoin('tag.labo', 'l')
            ->where('l.id = :labo')
            ->setParameter('labo', $id);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }
}

