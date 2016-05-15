<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Ed;
use AppBundle\Form\EdType;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }


    /**
     * @Route("/etablissement/{id}", name="etablissement")
     */
    public function etablissementAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $etablissement = $em->getRepository('AppBundle:Etablissement')->findOneByEtablissementId($id);
        $eds = $em->getRepository('AppBundle:Ed')->findAll();
        
        return $this->render('notice/etablissement.html.twig', array(
            'etablissement' => $etablissement,
            'eds' => $eds,
        ));
    }

    /**
     * @Route("/recherche/{id}", name="recherche")
     */
    public function laboratoireAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $laboratoire = $em->getRepository('AppBundle:Labo')->findOneByLaboId($id);
        
        return $this->render('notice/laboratoire.html.twig', array(
            'laboratoire' => $laboratoire,
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
            'etablissements' => $etablissements,
        ));
    }

    
    /**
     * @Route("/formation/{id}", name="formation")
     */
    public function formationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $formation = $em->getRepository('AppBundle:Formation')->findOneByFormationId($id);
        
        return $this->render('notice/formation.html.twig', array(
            'formation' => $formation,
        ));
    }




} // Fin de la class DefaultController


