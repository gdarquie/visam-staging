<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Labo;
use AppBundle\Form\LaboType;

/**
 * Labo controller.
 *
 * @Route("/labo")
 */
class LaboController extends Controller
{
    /**
     * Lists all Labo entities.
     *
     * @Route("/", name="labo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $labos = $em->getRepository('AppBundle:Labo')->findAll();

        return $this->render('labo/index.html.twig', array(
            'labos' => $labos,
        ));
    }

    /**
     * Creates a new Labo entity.
     *
     * @Route("/new", name="labo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $labo = new Labo();
        $form = $this->createForm('AppBundle\Form\LaboType', $labo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($labo);
            $em->flush();

            return $this->redirectToRoute('labo_show', array('id' => $labo->getId()));
        }

        return $this->render('labo/new.html.twig', array(
            'labo' => $labo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Labo entity.
     *
     * @Route("/{id}", name="labo_show")
     * @Method("GET")
     */
    public function showAction(Labo $labo)
    {
        $deleteForm = $this->createDeleteForm($labo);

        return $this->render('labo/show.html.twig', array(
            'labo' => $labo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Labo entity.
     *
     * @Route("/{id}/edit", name="labo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Labo $labo)
    {
        $deleteForm = $this->createDeleteForm($labo);
        $editForm = $this->createForm('AppBundle\Form\LaboType', $labo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($labo);
            $em->flush();

            return $this->redirectToRoute('labo_edit', array('id' => $labo->getId()));
        }

        return $this->render('labo/edit.html.twig', array(
            'labo' => $labo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Labo entity.
     *
     * @Route("/{id}", name="labo_delete")
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

        return $this->redirectToRoute('labo_index');
    }

    /**
     * Creates a form to delete a Labo entity.
     *
     * @param Labo $labo The Labo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Labo $labo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('labo_delete', array('id' => $labo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
