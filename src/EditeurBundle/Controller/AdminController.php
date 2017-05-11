<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * Page d'accueil administrateur
     *
     * @Route("/", name="admin")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT e FROM AppBundle:Etablissement e ORDER BY e.last_update DESC'
        );
        $etablissements = $query->getResult();

        $query = $em->createQuery(
            'SELECT f FROM AppBundle:Formation f ORDER BY f.last_update DESC'
        )->setMaxResults(5);
        $formations = $query->getResult();

        $query = $em->createQuery(
            'SELECT l FROM AppBundle:Labo l ORDER BY l.last_update DESC'
        )->setMaxResults(5);
        $labos = $query->getResult();

        $query = $em->createQuery(
            'SELECT e FROM AppBundle:Ed e ORDER BY e.last_update DESC'
        )->setMaxResults(5);
        $eds = $query->getResult();

        $query = $em->createQuery(
            'SELECT c FROM AppBundle:Collecte c ORDER BY c.annee DESC'
        );
        $collectes = $query->getResult();

        //année de collecte utilisée par le moteur de recherche
        $query = $em->createQuery(
            'SELECT c FROM AppBundle:Collecte c WHERE c.complete = true ORDER BY c.annee DESC'
        )->setMaxResults(1);
        $collecte = $query->getResult();

        //utilisateurs
        $query = $em->createQuery(
            'SELECT u FROM AppBundle:User u ORDER BY u.username DESC'
        )->setMaxResults(10);
        $users = $query->getResult();

        //thesaurus
        $query = $em->createQuery('SELECT t FROM AppBundle:Thesaurus t GROUP BY t.type');
        $thesaurus = $query->getResult();


        return $this->render('EditeurBundle:Admin:index.html.twig', array(
            'etablissements' => $etablissements,
            'formations' => $formations,
            'labos' => $labos,
            'eds' => $eds,
            'collectes' => $collectes,
            'collecte' => $collecte,
            'users' => $users,
            'thesaurus' => $thesaurus
        ));
    }

    /**
     * Page de gestion des thésaurus
     *
     * @Route("/thesaurus", name="admin_thesaurus")
     */
    public function thesaurusAction()
    {

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT t.nom, t.type FROM AppBundle:Thesaurus t ORDER BY t.type ASC'
        );
        $thesaurus = $query->getResult();

        $query = $em->createQuery(
            'SELECT t.type FROM AppBundle:Thesaurus t GROUP BY t.type ORDER BY t.type ASC'
        );
        $types = $query->getResult();

        return $this->render('EditeurBundle:Admin:thesaurus.html.twig', array(
            'thesaurus' => $thesaurus,
            'types' => $types
        ));
    }

}
