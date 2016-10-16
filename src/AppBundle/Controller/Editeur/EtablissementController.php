<?php

namespace AppBundle\Controller\Editeur;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\Etablissement;
use AppBundle\Form\EtablissementType;

/**
 *
 * @Route("/editeur/etablissement")
 */
class EtablissementController extends Controller
{

    /**
     * Etablissements
     *
     * @Route("/", name="editeur_etablisement")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return $this->render('', array(

        ));
    }

    /**
     * Créer un établissement
     *
     * @Route("/new", name="editeur_etablisement_new")
     */
    public function newAction(Request $request){

        $etablissement = new Etablissement();

        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $etablissement = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $etablissement->setDateCreation($now);
            $etablissement->setLastUpdate($now);

            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('editeur/etablissement/new.html.twig', array(
            'etablissementForm' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit" , name = "editeur_etablissement_edit")
     */
    public function editAction(Request $request, Etablissement $etablissement){

//        $deleteForm = $this->createDeleteEtablissementForm($etablissement);
        $etablissementForm = $this->createForm('AppBundle\Form\EtablissementType', $etablissement);
        $etablissementForm->handleRequest($request);


        if ($etablissementForm->isSubmitted() && $etablissementForm->isValid()){
            // dump($form->getData());die;

            $etablissement = $etablissementForm->getData();
            $now = new \DateTime();
            $etablissement->setLastUpdate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('editeur/etablissement/edit.html.twig', array(
            'etablissementForm' => $etablissementForm->createView()
        ));
    }



}





