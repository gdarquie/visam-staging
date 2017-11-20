<?php

namespace EditeurBundle\Controller;

use AppBundle\Entity\Valorisation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/editeur/valorisation")
 */
class ValorisationController extends Controller
{
    /**
     * Créer une valorisation
     *
     * @Route("/new", name="editeur_valorisation_new")
     */
    public function newValorisationAction(Request $request){

        $valorisation = new Valorisation();
        $editForm = $this->createForm('EditeurBundle\Form\ValorisationType', $valorisation);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $valorisation = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $valorisation->setDateCreation($now);
            $valorisation->setLastUpdate($now);

            $em->persist($valorisation);
            $em->flush();

            $this->addFlash(
                'notice',
                'Valorisation créée!'
            );
            return $this->redirectToRoute('editeur');
        }

        return $this->render('EditeurBundle:Valorisation:new.html.twig', array(
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Editer une valorisation
     *
     * @Route("/{id}/edit", name="editeur_valorisation_edit")
     */
    public function editFormationAction(Request $request, Valorisation $valorisation){

        $deleteForm = $this->createDeleteForm($valorisation);
        $editForm = $this->createForm('EditeurBundle\Form\ValorisationType', $valorisation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $valorisation = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $valorisation->setLastUpdate($now);

            $em->persist($valorisation);
            $em->flush();

            return $this->redirectToRoute('valorisation', array('id' => $valorisation->getValorisationId() ));
        }

        return $this->render('EditeurBundle:Valorisation:edit.html.twig', array(
            'valorisation' => $valorisation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Effacer une valorisation
     *
     * @Route("/{id}/delete", name="editeur_valorisation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, valorisation $valorisation)
    {
        $form = $this->createDeleteForm($valorisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($valorisation);
            $em->flush();
        }

        return $this->redirectToRoute('editeur');
    }

    /**
     * Créer un form pour effacer une valorisation
     *
     * @param valorisation $valorisation
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(valorisation $valorisation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('editeur_valorisation_delete', array('id' => $valorisation->getvalorisationId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
