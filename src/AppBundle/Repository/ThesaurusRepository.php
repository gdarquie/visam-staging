<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ThesaurusRepository extends EntityRepository
{
    public function findAllOrderdByTitle()
    {
        return $this->createQueryBuilder('thesaurus')
            ->orderBy('thesaurus.nom', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('thesaurus')
            ->orderBy('thesaurus.nom', 'ASC');

    }

    public function findAllThesaurusByType($type)
    {
        return $this->createQueryBuilder('thesaurus')
            ->where('thesaurus.type = :type')
            ->orderBy('thesaurus.nom', 'ASC')
            ->setParameter('type', $type);
    }

    public function findAllThesaurusByTypeAndCategory($type, $category)
    {
        return $this->createQueryBuilder('thesaurus')
            ->where('thesaurus.type = :type')
            ->andWhere("thesaurus.soustype = :category")
            ->orderBy('thesaurus.nom', 'ASC')
            ->setParameters(array( 'type' => $type, 'category' => $category));
    }
}



