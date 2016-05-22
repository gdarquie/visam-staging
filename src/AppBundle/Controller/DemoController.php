<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Ed;
use AppBundle\Entity\Etablissement;
use AppBundle\Entity\Formation;
use AppBundle\Entity\Discipline;

class DemoController extends Controller
{
    /**
     * @Route("/demo", name="demonstration")
     */
    public function demoAction(Request $request)
    {

    	$em = $this->getDoctrine()->getManager();
    	$eds = $em->getRepository('AppBundle:Ed')->findAll();
    	$etablissements = $em->getRepository('AppBundle:Etablissement')->findAll();
        $formations = $em->getRepository('AppBundle:Formation')->findAll();
        $disciplines = $em->getRepository('AppBundle:Discipline')->findAll();



        return $this->render('demo.html.twig', array(
        	'eds' => $eds,
            'formations' => $formations,
            'disciplines'=> $disciplines,
            'etablissements' => $etablissements,
        	));
    }


} // Fin de la class DefaultController


