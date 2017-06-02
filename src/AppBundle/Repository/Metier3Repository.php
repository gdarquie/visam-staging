<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class Metier3Repository extends EntityRepository
{

    public function existMetier($codeRome){

        $metier = $this
            ->findOneBy(array('code' => $codeRome));

        if (!$metier) {
            return false;
        }
        return true;
    }
}