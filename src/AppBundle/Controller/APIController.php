<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Ed;
use AppBundle\Entity\Discipline;
use AppBundle\Entity\Formation;
use AppBundle\Entity\Etablissement;



class APIController extends Controller
{   
    /**
     * @Route("/api/", name="api_index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('/api/index.html.twig'); //Page d'accueil de l'API/ C'est ici que se trouvera par exemple la documentation
    }

    /**
     * @Route("/api/test", name="api_test")
     */
    public function testAction(Request $request)
    {
        // return $this->render('/api/test.html.twig'); //Une page de test pour l'API
        // create a simple Response with a 200 status code (the default)
        $test = "Ceci est un test.";
        $response = new Response('Hello '.$test, Response::HTTP_OK);

        // create a JSON-response with a 200 status code
        $response = new Response(json_encode(array('test' => $test)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    //Définir des scénarios pour l'API

    //search

    //une fonction de recherce par formation par année
    /**
    * @Route("/api/recherche/formation/{string}", name="apiSearchFormation")
    */
    public function searchFormationAction($string)
    {

        //string  => 3 lettres min
        //recherche string parmi les noms de formation
        $em = $this->getDoctrine()->getManager();
        $formations = $em->getRepository('AppBundle:Formation')->findByAnnee($string);

        //je récupère les données coincindant avec la formation // à reprendre

        $liste = [];
          foreach ($formations as $formation){
                 //echo $formation->getFormationId();
                 //echo $formation->getNom();
                 array_push($liste, $formation->getNom());
         }

        // create a JSON-response with a 200 status code
        //$response = new Response(json_encode(array('formations' => $formations))); //faire le tableau plus

        
        $response = new Response();
        $response->setContent(json_encode($liste));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
    * @Route("/api/formations", name="apiGetAllFormations")
    */
    public function getAllFormationsAction()
    {

        $em = $this->getDoctrine()->getManager();
        $formations = $em->getRepository('AppBundle:Formation')->findAll();

        $liste = [];
          foreach ($formations as $formation){
                 array_push($liste, $formation->getNom());
                 array_push($liste, $formation->getAnnee());
                 array_push($liste, $formation->getTypeDiplome());
         }

        // create a JSON-response with a 200 status code
        //$response = new Response(json_encode(array('formations' => $formations))); //faire le tableau plus

        
        $response = new Response();
        $response->setContent(json_encode($liste));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    //Récupérer toutes les disciplines de toutres le formations

    /**
    * @Route("/api/disicplinesByformation", name="apiGetDisciplinesForAllFormations")
    */
        public function getAllDicicplinesForAllFormationsAction()
    {

        $em = $this->getDoctrine()->getManager();
        $formations = $em->getRepository('AppBundle:Formation')->findAll();

        $liste = [];
        $listeDiscipline =[];

        foreach ($formations as $formation){

        //array_push($liste, $formation->getNom());
        echo $formation->getNom();
        echo $formation->getDiscipline()->findAll();

        //echo $nom->getNom();
        //print_r($nom);
        //array_push($liste, $formation->getDiscipline()->getCode());
        //array_push($liste, $formation->getEtablissement());

        // foreach($disciplines as $discipline){
        //    array_push($liste, $discipline->getNom());

        //     }

             //print_r($disciplines);
             //array_push($liste, $formation->getEtablissement()->getNom());
     }

        // create a JSON-response with a 200 status code
        //$response = new Response(json_encode(array('formations' => $formations))); //faire le tableau plus

        
        $response = new Response();
        $response->setContent(json_encode($liste));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
    * @Route("/api/formation/{formationId}", name="apiGetFormationById")
    */
    function getAllDisciplinesFor1Formation($formationId){

        //récupérer une discpline

         $formation = $this->getDoctrine()
        ->getRepository('AppBundle:Formation')
        ->findAll();

    // $categoryName = $product->getCategory()->getName();
    //     $em = $this->getDoctrine()->getManager();

        $response = new Response();
        $response->setContent(json_encode($formation));



        $response->headers->set('Content-Type', 'application/json');

        foreach ($formations as $formation){};

        return $response;
    }


    /**
     * @Route("/api/map", name="apiMap")
     */
    public function mapAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT l.nom as nom, l.lat as lat, l.long as long, l.adresse FROM AppBundle:Localisation l')->setMaxResults(100);
        $map = $query->getResult();

        $response = new Response();
        $response->setContent(json_encode($map));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
       
    }


} // Fin de la class APIController


