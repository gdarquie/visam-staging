<?php

namespace AppBundle\Component\Stats;

class HandlerStats
{
    public function generalStats($em)
    {
        $stats = array();

        $query = $em->createQuery('SELECT COUNT(f) as nb FROM AppBundle:Formation f');
        $stats['nb_formations'] = $query->getSingleResult();

        $query = $em->createQuery('SELECT COUNT(l) as nb FROM AppBundle:Labo l');
        $stats['nb_laboratoires'] = $query->getSingleResult();

        $query = $em->createQuery('SELECT COUNT(e) as nb FROM AppBundle:Ed e');
        $stats['nb_eds'] = $query->getSingleResult();

        return $stats;
    }

}