<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Axe;
use AppBundle\Form\AxeType;

/**
 * Axe controller.
 *
 * @Route("/axe")
 */
class AxeController extends Controller
{
    /**
     * Lists all Axe entities.
     *
     * @Route("/", name="axe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $axes = $em->getRepository('AppBundle:Axe')->findAll();

        return $this->render('axe/index.html.twig', array(
            'axes' => $axes,
        ));
    }

    /**
     * Creates a new Axe entity.
     *
     * @Route("/new", name="axe_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $axe = new Axe();
        $form = $this->createForm('AppBundle\Form\AxeType', $axe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($axe);
            $em->flush();

            return $this->redirectToRoute('axe_show', array('id' => $axe->getAxeId()));
        }

        return $this->render('axe/new.html.twig', array(
            'axe' => $axe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Axe entity.
     *
     * @Route("/{id}", name="axe_show")
     * @Method("GET")
     */
    public function showAction(Axe $axe)
    {
        $deleteForm = $this->createDeleteForm($axe);

        return $this->render('axe/show.html.twig', array(
            'axe' => $axe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Axe entity.
     *
     * @Route("/{id}/edit", name="axe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Axe $axe)
    {
        $deleteForm = $this->createDeleteForm($axe);
        $editForm = $this->createForm('AppBundle\Form\AxeType', $axe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($axe);
            $em->flush();

            return $this->redirectToRoute('axe_edit', array('id' => $axe->getAxeId()));
        }

        return $this->render('axe/edit.html.twig', array(
            'axe' => $axe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Axe entity.
     *
     * @Route("/{id}", name="axe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Axe $axe)
    {
        $form = $this->createDeleteForm($axe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($axe);
            $em->flush();
        }

        return $this->redirectToRoute('axe_index');
    }

    /**
     * Creates a form to delete a Axe entity.
     *
     * @param Axe $axe The Axe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Axe $axe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('axe_delete', array('id' => $axe->getAxeId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
