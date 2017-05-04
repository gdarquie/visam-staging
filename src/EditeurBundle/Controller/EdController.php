<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


use AppBundle\Entity\Ed;
use EditeurBundle\Form\EdType;

/**
 *
 * @Route("/editeur")
 */
class EdController extends Controller
{

    /**
     * Lists all Ed entities.
     *
     * @Route("/ed", name="editeur_ed_index")
     * @Method("GET")
     */
    public function allEdAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eds = $em->getRepository('AppBundle:Ed')->findAll();

        return $this->render('EditeurBundle:Ed:index.html.twig', array(
            'eds' => $eds,
        ));
    }

    /**
     * Créer une nouvelle Ed
     *
     * @Route("/ed/new", name="editeur_ed_new")
     * @Method({"GET", "POST"})
     */
    public function newEdAction(Request $request)
    {
        $ed = new Ed();
        $form = $this->createForm('EditeurBundle\Form\EdType', $ed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ed = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->persist($ed);
            $em->flush();

            return $this->redirectToRoute('editeur_ed_edit', array('id' => $ed->getEdId()));
        }

        return $this->render('EditeurBundle:Ed:new.html.twig', array(
            'ed' => $ed,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ed entity.
     *
     * @Route("/ed/{id}", name="editeur_ed_show")
     * @Method("GET")
     */
    public function showEdAction(Ed $ed)
    {
        $deleteForm = $this->createDeleteEdForm($ed);

        return $this->render('EditeurBundle:Ed:show.html.twig', array(
            'ed' => $ed,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ed entity.
     *
     * @Route("/ed/{id}/edit", name="editeur_ed_edit")
     * @Method({"GET", "POST"})
     */
    public function editEdAction(Request $request, Ed $ed)
    {
        $deleteForm = $this->createDeleteEdForm($ed);
        $editForm = $this->createForm('EditeurBundle\Form\EdType', $ed);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $now = new \DateTime();
            $ed->setLastUpdate($now);

            $em->persist($ed);
            $em->flush();

            return $this->redirectToRoute('editeur_ed_edit', array('id' => $ed->getEdId()));
        }

        return $this->render('EditeurBundle:ed:edit.html.twig', array(
            'ed' => $ed,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ed entity.
     *
     * @Route("/ed/{id}", name="editeur_ed_delete")
     * @Method("DELETE")
     */
    public function deleteEdAction(Request $request, Ed $ed)
    {
        $form = $this->createDeleteEdForm($ed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ed);
            $em->flush();
        }

        return $this->redirectToRoute('editeur_ed_index');
    }

    /**
     * Creates a form to delete a Ed entity.
     *
     * @param Ed $ed The Ed entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteEdForm(Ed $ed)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('editeur_ed_delete', array('id' => $ed->getEdId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
