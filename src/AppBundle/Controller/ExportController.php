<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class ExportController extends Controller
{
    /**
     * @Route("/export", name="export")
     */
    public function exportAction(Request $request)
    {

    	$em = $this->getDoctrine()->getManager();

    	
        $formations = $em->getRepository('AppBundle:Formation')->findAll();
        $labos = $em->getRepository('AppBundle:Labo')->findAll();

        return $this->render('export.html.twig', array(
        	
            'formations' => $formations,
            'labos' => $labos,
        	));
    }


} // Fin de la class DefaultController


