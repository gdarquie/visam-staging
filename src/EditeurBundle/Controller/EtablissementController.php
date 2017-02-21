<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\Etablissement;
use EditeurBundle\Form\EtablissementType;

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

            $em = $this->getDoctrine()->getManager();
            $etablissement = $form->getData();

            $now = new \DateTime();
            $etablissement->setDateCreation($now);
            $etablissement->setLastUpdate($now);

            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('EditeurBundle:Etablissement:new.html.twig', array(
            'etablissementForm' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit" , name = "editeur_etablissement_edit")
     */
    public function editAction(Request $request, Etablissement $etablissement, $id){

        $deleteForm = $this->createDeleteForm($etablissement);
        $etablissementForm = $this->createForm('EditeurBundle\Form\EtablissementType', $etablissement);
        $etablissementForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $etablissement = $em->getRepository('AppBundle:Etablissement')->findOneByEtablissementId($id);

        if ($etablissementForm->isSubmitted() && $etablissementForm->isValid()){
            // dump($form->getData());die;

            $etablissement = $etablissementForm->getData();
            $now = new \DateTime();
            $etablissement->setLastUpdate($now);


            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('EditeurBundle:Etablissement:edit.html.twig', array(
            'etablissementForm' => $etablissementForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'etablissement' => $etablissement
        ));
    }


    /**
     * Effacer un établissement
     *
     * @Route("/{id}/delete", name="editeur_etablissement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etablissement $etablissement)
    {
        $form = $this->createDeleteForm($etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('editeur');
    }

    /**
     * Créer un form pour effacer un établissement
     *
     * @param Etablissement $etablissement
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Etablissement $etablissement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('editeur_etablissement_delete', array('id' => $etablissement->getEtablissementId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


}




