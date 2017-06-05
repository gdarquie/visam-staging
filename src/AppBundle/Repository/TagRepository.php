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


    public function getAllTagsForFormation($formationId)
    {
        $qb = $this->createQueryBuilder('tag')
            ->select('tag.nom')
            ->leftJoin('tag.formation', 'f')
            ->where('f.formationId = :formation')
            ->setParameter('formation', $formationId);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }

    public function getAllTagsForLabo($laboId)
    {
        $qb = $this->createQueryBuilder('tag')
            ->select('tag.nom')
            ->leftJoin('tag.labo', 'l')
            ->where('l.laboId = :labo')
            ->setParameter('labo', $laboId);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }
}

