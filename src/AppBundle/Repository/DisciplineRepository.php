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

    /***
     * verifier le value dans la BD
     * @param $value
     * @return boolean
     *
     */
    public function verifyDisciplineByAbreviation($value, $type)
    {
        $discipline = $this
            ->findOneBy(array('abreviation' => $value, 'type' => $type));

        if (!$discipline) {
            return false;
        }
        return true;
    }

    /***
     * verifier le value dans la BD
     * @param $value
     * @return boolean
     *
     */
    public function verifyDisciplineByNom($value, $type)
    {
        $discipline = $this
            ->findOneBy(array('nom' => $value, 'type' => $type));

        if (!$discipline) {
            return false;
        }
        return true;
    }

    public function findAllDisciplines($type)
    {
        $qb = $this->createQueryBuilder('d')
            ->select('d.nom, d.abreviation')
            ->where('d.type = :type')
            ->setParameter('type', $type);

        $query = $qb->getQuery()->getArrayResult();

        return $query;
    }

}
