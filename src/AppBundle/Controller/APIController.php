<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Ed;


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

    //une fonction de recherche par établissement


} // Fin de la class APIController


