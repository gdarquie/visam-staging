<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LaboController extends Controller
{
    /**
     * @Route("/api/labos", name="api_labos")
     */
    public function indexAction()
    {
        //get All labo
        $em = $this->getDoctrine()->getManager();
        $accueils = $em->getRepository('AppBundle:Labo')->findAll();
        dump($em->getRepository('AppBundle:Labo'));

//        return new JsonResponse($accueils);
        return $this->render('index.html.twig');

    }


}


