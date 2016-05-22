<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Ed;
use AppBundle\Entity\Etablissement;
use AppBundle\Entity\Formation;
use AppBundle\Entity\Labo;

class StatistiquesController extends Controller
{
    /**
     * @Route("/stats", name="statistiques")
     */
    public function indexAction(Request $request)
    {

    	$em = $this->getDoctrine()->getManager();
    	$eds = $em->getRepository('AppBundle:Ed')->findAll();
    	$etabs = $em->getRepository('AppBundle:Etablissement')->findAll();
        $formations = $em->getRepository('AppBundle:Formation')->findAll();
        $labos = $em->getRepository('AppBundle:Labo')->findAll();



        //Test pour faire des requêtes en SQL avec Symfony

        //calcul du nombre d'étudiant
        // récupérer la valeur d'une requête SQL qui sera exploitée dans nbEtud
        //SELECT SUM(`etudiants`) AS nb FROM etablissement

        $query = $em->createQuery(
            'SELECT p
            FROM AppBundle:Etablissement p
            WHERE p.etudiants > :etudiants'
        )->setParameter('etudiants', '60000');

        //$nbEtud = $query->setMaxResults(1)->getOneOrNullResult();


        $nbEtud = 125464;

        //calculer la répartition des niveaux dans les formations
        $query = $em->createQuery('SELECT n.niveau, COUNT(n.niveau) AS nb FROM AppBundle:Formation n GROUP BY n.niveau ORDER BY nb DESC');
        $nbFormations = $query->getResult();

        //récupérer toutes les formations et leurs disciplines
        $query = $em->createQuery('SELECT f.nom as nom, f.annee as annee FROM AppBundle:Formation f');
        $formationsDisciplines = $query->getResult();


        //toutes les formations de tous établissements

        return $this->render('stats.html.twig', array(
        	'eds' => $eds,
        	'etabs' => $etabs,
            'nbEtud' => $nbEtud,
            'formations' => $formations,
            'nbFormations'=> $nbFormations,
            'formationsDisciplines' => $formationsDisciplines,
            'labos' => $labos,
        	));
    }


} // Fin de la class DefaultController


