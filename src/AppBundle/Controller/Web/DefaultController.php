<?php

namespace AppBundle\Controller\Web;

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


        return $this->render('web/index.html.twig',  array(
            'hesamettes' => $hesamettes,
            'labosHesamette'=> $labosHesamette,
            'formationsHesamette' => $formationsHesamette,
            'equipements' => $equipements 
        ));

    }

    /**
     * @Route("/aide", name="aide")
     */
    public function aideAction(Request $request)
    {
        return $this->render('web/howto.html.twig'
        );
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
     * @Route("/rechercher/{string}", name="searchByString")
     */
    public function rechercheByStringAction(Request $request)
    {
        return $this->render('rechercher.html.twig'
        );
    }


    /**
     * @Route("/apropos", name="apropos")
     */
    public function aboutAction(Request $request)
    {
        return $this->render('web/apropos.html.twig'
        );
    }

    /**
     * @Route("/labo/{id}", name="labo")
     */
    public function laboratoireAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $laboratoire = $em->getRepository('AppBundle:Labo')->findOneByLaboId($id);
        // $labos = $em->getRepository('AppBundle:Labo')->findAll();
        $query = $em->createQuery('SELECT l FROM AppBundle:Labo l');
        $labos = $query->setMaxResults(3)->getResult();

        $query = $em->createQuery('SELECT h.nom as nom, COUNT(h) as nb FROM AppBundle:Discipline d JOIN d.labo f JOIN d.hesamette h WHERE f.laboId = :id GROUP BY h.nom ORDER BY nb DESC');
        $query->setParameter('id', $id);
        $hesamettes = $query->getResult();

        //$nbEtud = $query->setMaxResults(1)->getOneOrNullResult();

        $query = $em->createQuery('SELECT l FROM AppBundle:Axe l JOIN l.labo a WHERE a.laboId = :labo');
        $query->setParameter('labo', $id);
        $axes = $query->getResult();




        //Les Rebonds

        //Récupération de l'hésamette la plus importante pour le labo en question

        $query = $em->createQuery('SELECT COUNT(h.nom) as nb, h.nom as nom FROM AppBundle:Labo l JOIN l.discipline d JOIN d.hesamette h WHERE l.laboId = :id GROUP BY h.nom ORDER BY nb DESC');
        $query->setParameter('id', $id);
        $hesamettes_rebond = $query->setMaxResults(1)->getResult();
        $hesamette_rebond = $hesamettes_rebond[0]['nom'];

        //sélection des labos en fonction de l'hesamette principale
        $query = $em->createQuery('SELECT l FROM AppBundle:Labo l JOIN l.discipline d JOIN d.hesamette h WHERE h.nom = :hesamette');
        $query->setParameter('hesamette', $hesamette_rebond);
        $rebonds_labo = $query->setMaxResults(2)->getResult();

        //Sélection des formations
        $query = $em->createQuery('SELECT f FROM AppBundle:Formation f JOIN f.discipline d JOIN d.hesamette h WHERE h.nom = :hesamette');
        $query->setParameter('hesamette', $hesamette_rebond);
        $rebonds_formation = $query->setMaxResults(1)->getResult();

//        dump($rebond);die();

        
        return $this->render('notice/laboratoire.html.twig', array(
            'labo' => $laboratoire,
            'labos' => $labos,
            'hesamettes' => $hesamettes,
            'axes' => $axes,
            'rebonds_labo' => $rebonds_labo,
            'rebonds_formation' => $rebonds_formation,

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
            'formations' => $formations
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
            'etablissements' => $etablissements
        ));
    }

    
    /**
     * @Route("/formation/{id}", name="formation")
     */
    public function formationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $formation = $em->getRepository('AppBundle:Formation')->findOneByFormationId($id);
        $query = $em->createQuery('SELECT f FROM AppBundle:Formation f');
        $formations = $query->setMaxResults(3)->getResult();

        $query = $em->createQuery('SELECT h.nom as nom, COUNT(h) as nb FROM AppBundle:Discipline d JOIN d.formation f JOIN d.hesamette h WHERE f.formationId = :id GROUP BY h.nom ORDER BY nb DESC');
        $query->setParameter('id', $id);
        $hesamettes = $query->getResult();


        //Les rebonds
        $query = $em->createQuery('SELECT COUNT(h.nom) as nb, h.nom as nom FROM AppBundle:Formation f JOIN f.discipline d JOIN d.hesamette h WHERE f.formationId = :id GROUP BY h.nom ORDER BY nb DESC');
        $query->setParameter('id', $id);
        $hesamettes_rebond = $query->setMaxResults(1)->getResult();
        $hesamette_rebond = $hesamettes_rebond[0]['nom'];

        //sélection des labos en fonction de l'hesamette principale
        $query = $em->createQuery('SELECT l FROM AppBundle:Labo l JOIN l.discipline d JOIN d.hesamette h WHERE h.nom = :hesamette');
        $query->setParameter('hesamette', $hesamette_rebond);
        $rebonds_labo = $query->setMaxResults(1)->getResult();

        //Sélection des formations
        $query = $em->createQuery('SELECT f FROM AppBundle:Formation f JOIN f.discipline d JOIN d.hesamette h WHERE h.nom = :hesamette');
        $query->setParameter('hesamette', $hesamette_rebond);
        $rebonds_formation = $query->setMaxResults(2)->getResult();


        return $this->render('notice/formation.html.twig', array(
            'formation' => $formation,
            'formations' => $formations,
            'hesamettes' => $hesamettes,
            'rebonds_labo' => $rebonds_labo,
            'rebonds_formation' => $rebonds_formation,
        ));
    }

    /**
     * @Route("/secret/2016", name="secret2016")
     */
    public function secret2016Action(Request $request)
    {
        return $this->render('web/secret/2016.html.twig');
    }

    //prochain secret :une petite IF à secret/XYZZY




} // Fin de la class DefaultController


