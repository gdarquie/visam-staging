<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Membre;
use EditeurBundle\Form\MembreType;

/**
 * @Route("/editeur/membre")
 */
class MembreController extends Controller
{
    /**
     * Créer un membre
     *
     * @Route("/new", name="editeur_membre_new")
     */
    public function newAction(Request $request){

        $membre = new Membre();
        $editForm = $this->createForm('EditeurBundle\Form\MembreType', $membre);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $membre = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $em->persist($membre);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('EditeurBundle:Membre:new.html.twig', array(
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Editer un membre
     *
     * @Route("/{id}/edit", name="editeur_membre_edit")
     */
    public function editMembreAction(Request $request, Membre $membre){

        $deleteForm = $this->createDeleteForm($membre);
        $editForm = $this->createForm('EditeurBundle\Form\LaboType', $membre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $membre = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $membre->setLastUpdate($now);

            $em->persist($membre);
            $em->flush();

            return $this->redirectToRoute('labo', array('id' => $membre->getId() ));
        }

        return $this->render('EditeurBundle:Membre:edit.html.twig', array(
            'membre' => $membre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Effacer un labo
     *
     * @Route("/{id}/delete", name="editeur_membre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Membre $membre)
    {
        $form = $this->createDeleteForm($membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($labo);
            $em->flush();
        }

        return $this->redirectToRoute('editeur');
    }

    /**
     * Créer un form pour effacer un membre
     *
     * @param Membre $membre
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Membre $membre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('membre_delete', array('id' => $membre->getMembreId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}




