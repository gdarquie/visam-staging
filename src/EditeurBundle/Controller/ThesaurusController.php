<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Thesaurus;
use EditeurBundle\Form\LaboType;

/**
 *
 * @Route("/editeur/thesaurus")
 */
class ThesaurusController extends Controller
{
    /**
     * Créer un thesaurus
     *
     * @Route("/new", name="editeur_thesaurus_new")
     */
    public function newLaboAction(Request $request){

        $thesaurus = new Thesaurus();
        $editForm = $this->createForm('EditeurBundle\Form\ThesaurusType', $thesaurus);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $thesaurus = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $thesaurus->setDateCreation($now);
            $thesaurus->setLastUpdate($now);

            $em->persist($thesaurus);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('EditeurBundle:Thesaurus:new.html.twig', array(
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Editer un laboratoire
     *
     * @Route("/{id}/edit", name="editeur_thesaurus_edit")
     */
    public function editFormationAction(Request $request, Labo $laboratoire){

        $deleteForm = $this->createDeleteForm($laboratoire);
        $editForm = $this->createForm('EditeurBundle\Form\LaboType', $laboratoire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $laboratoire = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $laboratoire->setLastUpdate($now);

            $em->persist($laboratoire);
            $em->flush();

            return $this->redirectToRoute('labo', array('id' => $laboratoire->getLaboId() ));
        }

        return $this->render('EditeurBundle:Labo:edit.html.twig', array(
            'labo' => $laboratoire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Effacer un labo
     *
     * @Route("/{id}/delete", name="editeur_thesaurus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Labo $labo)
    {
        $form = $this->createDeleteForm($labo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($labo);
            $em->flush();
        }

        return $this->redirectToRoute('editeur');
    }

    /**
     * Créer un form pour effacer un labo
     *
     * @param Labo $labo
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Labo $labo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('editeur_laboratoire_delete', array('id' => $labo->getLaboId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
