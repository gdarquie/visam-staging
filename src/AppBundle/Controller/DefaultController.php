<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Ed;
use AppBundle\Form\EdType;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $hesamettes = $em->getRepository('AppBundle:Hesamette')->findAll();
        $equipements = $em->getRepository('AppBundle:Equipement')->findAll();

         //nombre de formations par hesamettes
        $query = $em->createQuery('SELECT h.nom as hesamette, COUNT(f) as nb, f.nom as formation FROM AppBundle:Discipline d JOIN d.formation f JOIN d.hesamette h GROUP BY h ORDER BY nb DESC');
        $formationsHesamette = $query->getResult();


        //répartition des hesamettes par labos
        $query = $em->createQuery('SELECT h.nom as hesamette, COUNT(l) as nb, l.nom as labo FROM AppBundle:Discipline d JOIN d.labo l JOIN d.hesamette h GROUP BY h ORDER BY nb DESC');
        $labosHesamette = $query->getResult();


        return $this->render('default/index.html.twig',  array(
            'hesamettes' => $hesamettes,
            'labosHesamette'=> $labosHesamette,
            'formationsHesamette' => $formationsHesamette,
            'equipements' => $equipements 
        ));


    }
    
    /**
     * @Route("/rechercher", name="search")
     */
    public function rechercheAction(Request $request)
    {
        return $this->render('rechercher.html.twig'
        );
    }
    
    /**
     * @Route("/apropos", name="apropos")
     */
    public function aboutAction(Request $request)
    {
        return $this->render('apropos.html.twig'
        );
    }

    /**
     * @Route("/labo/{id}", name="recherche")
     */
    public function laboratoireAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $laboratoire = $em->getRepository('AppBundle:Labo')->findOneByLaboId($id);
        // $labos = $em->getRepository('AppBundle:Labo')->findAll();
        $query = $em->createQuery('SELECT l FROM AppBundle:Labo l');
        $labos = $query->setMaxResults(3)->getResult();

        //$nbEtud = $query->setMaxResults(1)->getOneOrNullResult();
        
        return $this->render('notice/laboratoire.html.twig', array(
            'labo' => $laboratoire,
            'labos' => $labos

        ));
    }

    /**
     * @Route("/etablissement/{id}", name="etablissement")
     */
    public function etablissementAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $etablissement = $em->getRepository('AppBundle:Etablissement')->findOneByEtablissementId($id);
        $eds = $em->getRepository('AppBundle:Ed')->findAll(); //récupérer seulement les ed de l'établissement
        $formations = $em->getRepository('AppBundle:Formation')->findAll();

        
        return $this->render('notice/etablissement.html.twig', array(
            'etablissement' => $etablissement,
            'eds' => $eds,
            'formations' => $formations,
        ));
    }


    /**
     * @Route("/ed/{id}", name="ed")
     */
    public function edAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $ed = $em->getRepository('AppBundle:Ed')->findOneByEdId($id);
        $etablissements = $em->getRepository('AppBundle:Etablissement')->findAll();
        
        return $this->render('notice/ed.html.twig', array(
            'ed' => $ed,
            'etablissements' => $etablissements,
        ));
    }

    
    /**
     * @Route("/formation/{id}", name="formation")
     */
    public function formationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $formation = $em->getRepository('AppBundle:Formation')->findOneByFormationId($id);
        $formations = $em->getRepository('AppBundle:Formation')->findAll();

        $query = $em->createQuery('SELECT h.nom as nom, COUNT(h) as nb FROM AppBundle:Discipline d JOIN d.formation f JOIN d.hesamette h WHERE f.formationId = :id GROUP BY h.nom ORDER BY nb DESC');
        $query->setParameter('id', $id);
        $hesamettes = $query->getResult();

        $idLabosLies = [];
        $labosLies = ""; //Tous les labos qui ont appartiennent aux mêmes trois hesamettes
        
        return $this->render('notice/formation.html.twig', array(
            'formation' => $formation,
            'formations' => $formations,
            'hesamettes' => $hesamettes
        ));
    }




} // Fin de la class DefaultController


