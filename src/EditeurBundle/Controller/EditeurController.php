<?php

namespace EditeurBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ed;
use AppBundle\Entity\Etablissement;
use AppBundle\Entity\Formation;
use AppBundle\Entity\Labo;


/**
 * Editeur controller.
 *
 * @Route("/editeur")
 */
class EditeurController extends Controller
{


    /**
     * Accueil de l'éditeur
     *
     * @Route("/", name="editeur")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //récupérer l'année de la dernière collecte active
        $query = $em->createQuery(
            'SELECT c.annee FROM AppBundle:Collecte c WHERE c.active = 1'
        )->setMaxResults(1);
        $annee = $query->getResult();

        //s'il n'y a pas de collecte active, on renvoie directement sur le moteur de recherche
        if(COUNT($annee)  == 0){
            return $this->redirectToRoute('search');
        }
        $annee = $annee[0]['annee'];

//        dump($annee);die;

        $user = $this->getUser();
        $userId = $user->getId();

    //Récupérer les ids des établissements liés à un membre
        if ($user->hasRole('ROLE_ADMIN')){
            $query = $em->createQuery(
                'SELECT e.etablissementId as id FROM AppBundle:Etablissement e JOIN e.collecte c WHERE c.active = 1 '
            );
            $associations = $query->getResult();
        }

        else{
            $query = $em->createQuery(
                'SELECT e.etablissementId as id FROM AppBundle:User u INNER JOIN u.etablissement e WHERE u.id = :user'
            );
            $query->setParameter('user', $userId);
            $associations = $query->getResult();
        }

    //Get établissement(s) lié(s) à un membre - il peut éventuellement y en avoir plusieurs
        $sql = "SELECT e FROM AppBundle:Etablissement e ";
        foreach ($associations as $key=>$value) {
            if($key == 0){
                $sql = $sql." WHERE e.etablissementId = :etablissement".$key;
            }

            else{
                $sql = $sql." OR e.etablissementId = :etablissement".$key;
            }
        }

        $query = $em->createQuery($sql);
        foreach ($associations as $key=>$value) {
            $query->setParameter('etablissement'.$key, $associations[$key]['id']);
        }
        $etablissements = $query->getResult();

//        dump($etablissements);die();

    //Get all formations des établissements retenus
        $sql = "SELECT f FROM AppBundle:Formation f INNER JOIN f.etablissement e WHERE f.anneeCollecte = :annee";
        foreach ($etablissements as $key=>$value) {
            if($key == 0){
                $sql = $sql." AND (e.etablissementId = :etablissement".$key;
            }

            else{
                $sql = $sql." OR e.etablissementId = :etablissement".$key;
            }
        }
        $sqlEnd = " ORDER BY f.last_update DESC";
        $query = $em->createQuery($sql.")".$sqlEnd);
        $query->setParameter('annee', $annee);
        foreach ($associations as $key=>$value) {
            $query->setParameter('etablissement'.$key, $associations[$key]['id']);
        }
        $formations = $query->getResult();
//        dump($query);die();

    //Get all labo des établissements retenus

        $sql = "SELECT l FROM AppBundle:Labo l INNER JOIN l.etablissement e  WHERE l.anneeCollecte = :annee";
        foreach ($etablissements as $key=>$value) {
            if($key == 0){
                $sql = $sql." AND (e.etablissementId = :etablissement".$key;
            }

            else{
                $sql = $sql." OR e.etablissementId = :etablissement".$key;
            }
        }
        $sqlEnd = " ORDER BY l.last_update DESC";
        $query = $em->createQuery($sql.")".$sqlEnd);
        $query->setParameter('annee', $annee);
        foreach ($associations as $key=>$value) {
            $query->setParameter('etablissement'.$key, $associations[$key]['id']);
        }
        $laboratoires = $query->getResult();
//        dump($query);die();

    //Get all écoles doctorales des établissements retenus
        $sql = "SELECT d FROM AppBundle:Ed d INNER JOIN d.etablissement e  WHERE d.anneeCollecte = :annee";
        foreach ($etablissements as $key=>$value) {
            if($key == 0){
                $sql = $sql." AND (d.edId = :ed".$key;
            }

            else{
                $sql = $sql." OR d.edId = :ed".$key;
            }
        }
        $sqlEnd = " ORDER BY d.last_update DESC";
        $query = $em->createQuery($sql.")".$sqlEnd);
        $query->setParameter('annee', $annee);
        foreach ($associations as $key=>$value) {
            $query->setParameter('ed'.$key, $associations[$key]['id']);
        }
        $eds = $query->getResult();

        return $this->render('EditeurBundle:Editeur:index.html.twig', array(
            'user' => $user,
            'etablissements' => $etablissements,
            'formations' => $formations,
            'laboratoires' => $laboratoires,
            'eds' => $eds,
        ));
    }

    /**
     * Ancien accueil de l'éditeur
     *
     * @Route("/oldaccueil", name="editeur_old")
     * @Method("GET")
     */
    public function oldindexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('AppBundle:Etablissement')->findAll();

        $query = $em->createQuery(
            'SELECT f FROM AppBundle:Formation f ORDER BY f.last_update DESC'
        )->setMaxResults(10);
        $formations = $query->getResult();

        $query = $em->createQuery(
            'SELECT l FROM AppBundle:Labo l ORDER BY l.last_update DESC'
        )->setMaxResults(10);
        $laboratoires = $query->getResult();

        return $this->render('EditeurBundle:Default:index.html.twig', array(
            'etablissements' => $etablissements,
            'formations' => $formations,
            'laboratoires' => $laboratoires
        ));
    }


    /**
     * Synthèse
     *
     * @Route("/synthese", name="editeur_synthese")
     * @Method("GET")
     */
    public function syntheseAction()
    {
        $em = $this->getDoctrine()->getManager();

        $max = 10;
        $offset = 10;

        $query = $em->createQuery(
            'SELECT f FROM AppBundle:Formation f'
        )->setMaxResults($max)->setFirstResult(10);

        $formations = $query->getResult();
        $labos = $em->getRepository('AppBundle:Labo')->findAll();
        $etabs = $em->getRepository('AppBundle:Etablissement')->findAll();

        return $this->render('EditeurBundle:Default:synthese.html.twig', array(
            'labos' => $labos,
            'etabs' => $etabs,
            'formations' => $formations,
            ));
    }




}
