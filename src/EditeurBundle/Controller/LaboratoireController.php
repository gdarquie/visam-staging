<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Labo;
use AppBundle\Form\LaboType;


/**
 *
 * @Route("/editeur/laboratoire")
 */
class LaboratoireController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * Créer un laboratoire
     *
     * @Route("/new", name="editeur_laboratoire_new")
     */
    public function newLaboAction(Request $request){

        $laboratoire = new Labo();
        $editForm = $this->createForm('EditeurBundle\Form\LaboType', $laboratoire);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $laboratoire = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $laboratoire->setDateCreation($now);
            $laboratoire->setLastUpdate($now);

            $em->persist($laboratoire);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('EditeurBundle:Labo:new.html.twig', array(
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Editer un laboratoire
     *
     * @Route("/{id}/edit", name="editeur_laboratoire_edit")
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
     * @Route("/{id}/delete", name="editeur_laboratoire_delete")
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
