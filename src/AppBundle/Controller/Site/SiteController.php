<?php

namespace AppBundle\Controller\Site;

use AppBundle\Component\Stats\HandlerStats;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SiteController extends Controller
{

    /**
     * @Route("/aide", name="aide")
     */
    public function aideAction(Request $request)
    {
        return $this->render('web/howto.html.twig'
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
     * @Route("/previz", name="search_previz")
     */
    public function recherchePrevizAction(Request $request)
    {
        return $this->render('previz.html.twig'
        );
    }

    /**
     * @Route("/previz/{string}", name="searchByString")
     */
    public function recherchePrevizByStringAction(Request $request)
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

        $laboratoire = $em->getRepository('AppBundle:Labo')->findOneById($id);
        // $labos = $em->getRepository('AppBundle:Labo')->findAll();
        $query = $em->createQuery('SELECT l FROM AppBundle:Labo l');
        $labos = $query->setMaxResults(3)->getResult();

        $query = $em->createQuery('SELECT h.nom as nom, COUNT(h) as nb FROM AppBundle:Discipline d JOIN d.labo f JOIN d.hesamette h WHERE f.id = :id GROUP BY h.nom ORDER BY nb DESC');
        $query->setParameter('id', $id);
        $hesamettes = $query->getResult();

        //$nbEtud = $query->setMaxResults(1)->getOneOrNullResult();

        $query = $em->createQuery('SELECT l FROM AppBundle:Axe l JOIN l.labo a WHERE a.id = :labo');
        $query->setParameter('labo', $id);
        $axes = $query->getResult();


        //Les Rebonds

        //Récupération de l'hésamette la plus importante pour le labo en question

        $query = $em->createQuery('SELECT COUNT(h.nom) as nb, h.nom as nom FROM AppBundle:Labo l JOIN l.discipline d JOIN d.hesamette h WHERE l.id = :id GROUP BY h.nom ORDER BY nb DESC');
        $query->setParameter('id', $id);
        $hesamettes_rebond = $query->setMaxResults(1)->getResult();
//        $hesamette_rebond = $hesamettes_rebond[0]['nom'];

        // Au cas où il n'y a pas de disciplines entrées
        if(count($hesamettes_rebond) > 0){
            $hesamette_rebond = $hesamettes_rebond[0]['nom'];
        }
        else{
            $hesamette_rebond = 0;
        }

        //sélection des labos en fonction de l'hesamette principale
        $query = $em->createQuery('SELECT l FROM AppBundle:Labo l JOIN l.discipline d JOIN d.hesamette h WHERE h.nom = :hesamette AND l.id != :id ORDER BY RAND()');
        $query->setParameter('hesamette', $hesamette_rebond);
        $query->setParameter('id', $id);
        $rebonds_labo = $query->setMaxResults(2)->getResult();

        //Sélection des formations
        $query = $em->createQuery('SELECT f FROM AppBundle:Formation f JOIN f.discipline d JOIN d.hesamette h WHERE h.nom = :hesamette ORDER BY RAND()');
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

        $query = $em->createQuery('SELECT f FROM AppBundle:Formation f JOIN f.etablissement e WHERE e.etablissementId = :id');
        $query->setParameter('id', $id);
        $formations = $query->getResult();

        $query = $em->createQuery('SELECT l FROM AppBundle:Labo l JOIN l.etablissement e WHERE e.etablissementId = :id');
        $query->setParameter('id', $id);
        $labos = $query->getResult();

        $query = $em->createQuery('SELECT f FROM AppBundle:Ed f JOIN f.etablissement e WHERE e.etablissementId = :id');
        $query->setParameter('id', $id);
        $eds = $query->getResult();

        return $this->render('notice/etablissement.html.twig', array(
            'etablissement' => $etablissement,
            'eds' => $eds,
            'formations' => $formations,
            'labos' => $labos,
            'collecte' => 0
        ));
    }

    /**
     * @Route("/etablissement/{id}/{annee}", name="etablissement_collecte")
     */
    public function etablissementCollecteAction($id, $annee)
    {

        $em = $this->getDoctrine()->getManager();

        $etablissement = $em->getRepository('AppBundle:Etablissement')->findOneByEtablissementId($id);

        $query = $em->createQuery('SELECT f FROM AppBundle:Formation f JOIN f.etablissement e WHERE e.etablissementId = :id AND f.anneeCollecte = :annee');
        $query->setParameter('id', $id);
        $query->setParameter('annee', $annee);
        $formations = $query->getResult();

        $query = $em->createQuery('SELECT l FROM AppBundle:Labo l JOIN l.etablissement e WHERE e.etablissementId = :id AND l.anneeCollecte = :annee');
        $query->setParameter('id', $id);
        $query->setParameter('annee', $annee);
        $labos = $query->getResult();

        $query = $em->createQuery('SELECT f FROM AppBundle:Ed f JOIN f.etablissement e WHERE e.etablissementId = :id AND f.anneeCollecte = :annee');
        $query->setParameter('id', $id);
        $query->setParameter('annee', $annee);
        $eds = $query->getResult();

        return $this->render('notice/etablissement.html.twig', array(
            'etablissement' => $etablissement,
            'eds' => $eds,
            'formations' => $formations,
            'labos' => $labos,
            'collecte' => $annee
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
//        $query = $em->createQuery('SELECT f FROM AppBundle:Formation f WHERE f.id = :id');
//        $query->setParameter('id', $id);
//        $formation = $query->getSingleResult();

//        dump($formation->getLocalisation());die;
        $formation = $em->getRepository('AppBundle:Formation')->findOneById($id);



        $query = $em->createQuery('SELECT f FROM AppBundle:Formation f');
        $formations = $query->setMaxResults(3)->getResult();

        $query = $em->createQuery('SELECT h.nom as nom, COUNT(h) as nb FROM AppBundle:Discipline d JOIN d.formation f JOIN d.hesamette h WHERE f.id = :id GROUP BY h.nom ORDER BY nb DESC');
        $query->setParameter('id', $id);
        $hesamettes = $query->getResult();


        //Les rebonds
        $query = $em->createQuery('SELECT COUNT(h.nom) as nb, h.nom as nom FROM AppBundle:Formation f JOIN f.discipline d JOIN d.hesamette h WHERE f.id = :id GROUP BY h.nom ORDER BY nb DESC');
        $query->setParameter('id', $id);
        $hesamettes_rebond = $query->setMaxResults(1)->getResult();

        //S'il n'y a pas de rebonds associés, hesamette rebond prend une valeur prédéfinie
        if(isset($hesamettes_rebond) AND count($hesamettes_rebond) > 0 ){
            $hesamette_rebond = $hesamettes_rebond[0]['nom'];
        }
        else{
            $hesamette_rebond = "inconnu";
        }


        //sélection des labos en fonction de l'hesamette principale
        $query = $em->createQuery('SELECT l FROM AppBundle:Labo l JOIN l.discipline d JOIN d.hesamette h WHERE h.nom = :hesamette ORDER BY RAND()');
        $query->setParameter('hesamette', $hesamette_rebond);
        $rebonds_labo = $query->setMaxResults(1)->getResult();


        //Sélection des formations
        $query = $em->createQuery('SELECT f FROM AppBundle:Formation f JOIN f.discipline d JOIN d.hesamette h WHERE h.nom = :hesamette AND f.id != :id ORDER BY RAND()');
        $query->setParameter('hesamette', $hesamette_rebond);
        $query->setParameter('id', $id);
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
     * @Route("/news", name="news")
     */
    public function newsAction()
    {
        return $this->render('web/news/index.html.twig');
    }


    /**
     * @Route("/secret/2016", name="secret2016")
     */
    public function secret2016Action()
    {
        return $this->render('web/secret/2016.html.twig');
    }

    //prochain secret :une petite IF à secret/XYZZY

//    /**
//     * @Route("secret/annand/", name="annand")
//     */
//    public function annandAction()
//    {
//        return $this->render('web/secret/annand.html.twig');
//    }




} // Fin de la class DefaultController


