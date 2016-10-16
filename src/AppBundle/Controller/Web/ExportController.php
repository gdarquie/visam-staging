<?php

namespace AppBundle\Controller\Web;

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

//        $cache = $this->get('doctrine_cache.providers.export_cache');
//
//        if ($cache->contains(10) && $cache->contains(11)) {
//            $formations = $cache->fetch(10);
//            $labos = $cache->fetch(11);
//        }
//        else{
//            $em = $this->getDoctrine()->getManager();
//            $labos = $em->getRepository('AppBundle:Labo')->findAll();
//            $formations = $em->getRepository('AppBundle:Formation')->findAll();
//
//            $cache->save(10, $formations);
//            $cache->save(11, $labos);
//        }

        $em = $this->getDoctrine()->getManager();
        $labos = $em->getRepository('AppBundle:Labo')->findAll();
        $formations = $em->getRepository('AppBundle:Formation')->findAll();

        return $this->render('export.html.twig', array(
            'formations' => $formations,
            'labos' => $labos,
        	));
    }


} // Fin de la class DefaultController


