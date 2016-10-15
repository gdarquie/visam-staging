<?php

namespace AppBundle\Controller\Web;

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
