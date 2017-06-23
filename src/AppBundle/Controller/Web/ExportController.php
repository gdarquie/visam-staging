<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class ExportController extends Controller
{
    /**
     * @Route("/carto/export", name="export")
     */
    public function exportAction(Request $request)
    {

//        $cache = $this->get('doctrine_cache.providers.export_cache');
//
//        if ($cache->contains(10) && $cache->contains(11)) {
//            $formations = $cache->fetch(10);
//            $labos = $cache->fetch(11);
//        }
//        else{
//            $em = $this->getDoctrine()->getManager();
//            $labos = $em->getRepository('AppBundle:Labo')->findAll();
//            $formations = $em->getRepository('AppBundle:Formation')->findAll();
//
//            $cache->save(10, $formations);
//            $cache->save(11, $labos);
//        }


        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT c FROM AppBundle:Collecte c WHERE c.complete = 1 ORDER BY c.annee DESC'
        )->setMaxResults(1);
        $anneeCollecte = $query->getSingleResult();

        $anneeCollecte = $anneeCollecte->getAnnee();

//        dump($anneeCollecte);die;

        $query = $em->createQuery(
            'SELECT l FROM AppBundle:Labo l WHERE l.anneeCollecte = :annee'
        );
        $query->setParameter('annee', $anneeCollecte);
//        $query->setMaxResults(10);
        $labos = $query->getResult();

        $query = $em->createQuery(
            'SELECT f FROM AppBundle:Formation f WHERE f.anneeCollecte = :annee'
        );
        $query->setParameter('annee', $anneeCollecte);
//        $query->setMaxResults(10);
        $formations = $query->getResult();


        return $this->render('export.html.twig', array(
            'formations' => $formations,
            'labos' => $labos,
        	));
    }


    /**
     * @Route("/export/previz", name="export_previz")
     */
    public function exportPrevizAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT c FROM AppBundle:Collecte c WHERE c.active = 1'
        )->setMaxResults(1);
        $anneeCollecte = $query->getSingleResult();

        $anneeCollecte = $anneeCollecte->getAnnee();

//        dump($anneeCollecte);die;

        $query = $em->createQuery(
            'SELECT l FROM AppBundle:Labo l WHERE l.anneeCollecte = :annee'
        );
        $query->setParameter('annee', $anneeCollecte);
        $labos = $query->getResult();

        $query = $em->createQuery(
            'SELECT f FROM AppBundle:Formation f WHERE f.anneeCollecte = :annee'
        );
        $query->setParameter('annee', $anneeCollecte);
        $formations = $query->getResult();


        return $this->render('export.html.twig', array(
            'formations' => $formations,
            'labos' => $labos,
        ));
    }

} // Fin de la class DefaultController


