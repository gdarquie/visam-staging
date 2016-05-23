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
        $disciplines = $em->getRepository('AppBundle:Discipline')->findAll();
        $localisations = $em->getRepository('AppBundle:Localisation')->findAll();


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

// ------------------------------------------------------------------------
// ------------------------------------ Disciplines ------------------------------------
// ------------------------------------------------------------------------       

//Toutes les disciplines (pour l'instant ne prend en compte que les formations mais il faudra ajouter les labo et les ED)

        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $allDisciplines = $query->getResult();

        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées SISE
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type=:type GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $query->setParameter('type', 'SISE');
        $allSiseDisciplines = $query->getResult();

        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées HCERES
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type=:type GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $query->setParameter('type', 'HCERES');
        $allHceresDisciplines = $query->getResult();

        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées CNU
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type=:type GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $query->setParameter('type', 'CNU');
        $allCnuDisciplines = $query->getResult();


        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées NW3
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type=:type GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $query->setParameter('type', 'NW3');
        $allNw3Disciplines = $query->getResult();


//Domaines (en cours)

        //récupérer tous les domaines des formations
        $query = $em->createQuery('SELECT d as item FROM AppBundle:Discipline d')->setMaxResults(20);
        $allDomainesDisciplines = $query->getResult();

//Disciplines des formations

        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $allDisciplinesFormations = $query->getResult();

        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées SISE
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type=:type GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $query->setParameter('type', 'SISE');
        $allSiseDisciplinesFormations = $query->getResult();

        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées HCERES
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type=:type GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $query->setParameter('type', 'HCERES');
        $allHceresDisciplinesFormations = $query->getResult();

        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées CNU
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type=:type GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $query->setParameter('type', 'CNU');
        $allCnuDisciplinesFormations = $query->getResult();


        //récupérer toutes les formations, leurs disciplines et le nombre de disciplines liées NW3
        $query = $em->createQuery('SELECT d as item, COUNT(f.nom) as nb, f.nom as formation, f.formationId as id FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type=:type GROUP BY d ORDER BY nb DESC')->setMaxResults(20);
        $query->setParameter('type', 'NW3');
        $allNw3DisciplinesFormations = $query->getResult();

        //toutes les formations de tous établissements

// ------------------------------------------------------------------------
// ------------------------------------ Localisation ------------------------------------
// ------------------------------------------------------------------------  

        //localisations pour la map
        $query = $em->createQuery('SELECT l.nom as nom, l.lat as lat, l.long as long, l.adresse FROM AppBundle:Localisation l')->setMaxResults(100);
        $map = $query->getResult();



        return $this->render('stats.html.twig', array(
        	'eds' => $eds,
        	'etabs' => $etabs,
            'nbEtud' => $nbEtud,
            'formations' => $formations,
            'nbFormations'=> $nbFormations,
            //toutes les disciplines
            'allDisciplines'=>$allDisciplines,
            'allSiseDisciplines'=>$allSiseDisciplines,
            'allHceresDisciplines'=>$allHceresDisciplines,
            'allCnuDisciplines'=>$allCnuDisciplines,
            'allNw3Disciplines'=>$allNw3Disciplines,
            //formations>Disciplines
            'allDisciplinesFormations'=>$allDisciplinesFormations,
            'allSiseDisciplinesFormations'=>$allSiseDisciplinesFormations,
            'allHceresDisciplinesFormations'=>$allHceresDisciplinesFormations,
            'allCnuDisciplinesFormations'=>$allCnuDisciplinesFormations,
            'allNw3DisciplinesFormations'=>$allNw3DisciplinesFormations,
            //entités
            'labos' => $labos,
            'disciplines' => $disciplines,
            'localisations' =>$localisations,
            'map' => $map,
        	));
    }


} // Fin de la class DefaultController


