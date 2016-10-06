<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Formation;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api/formations")
 */
class FormationController extends Controller
{
    /**
     * @Route("/test", name="api_formations")
     */
    public function indexAction()
    {
        //get All formations
        $em = $this->getDoctrine()->getManager();
        $accueils = $em->getRepository('AppBundle:Formation')->findAllFormationsApi();

        return new JsonResponse($accueils);
//        return $this->render('index.html.twig');
    }
}
