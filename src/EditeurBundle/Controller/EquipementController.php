<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Equipement;

/**
 *
 * @Route("/editeur/equipement")
 */
class EquipementController extends Controller
{
    /**
     * Créer une equipement
     *
     * @Route("/new", name="editeur_equipement_new")
     */
    public function newEquipementAction(Request $request){

        // $deleteForm = $this->createDeleteLaboForm($labo);

        $equipement = new Equipement();
        $form = $this->createForm('EditeurBundle\Form\EquipementType', $equipement);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $equipement = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->persist($equipement);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('EditeurBundle:Equipement:new.html.twig', array(
            'edit_form' => $form->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Editer une equipement
     *
     * @Route("/{id}/edit", name="editeur_equipement_edit")
     */
    public function editEquipementAction(Request $request, Equipement $equipement){

        $deleteForm = $this->createDeleteForm($equipement);
        $editForm = $this->createForm('EditeurBundle\Form\EquipementType', $equipement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $equipement->setLastUpdate($now);

            $em->persist($equipement);
            $em->flush();

            return $this->redirectToRoute('equipement', array('id' => $equipement->getEquipementId() ));

        }

        return $this->render('EditeurBundle:Equipement:edit.html.twig', array(
            'equipement' => $equipement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Effacer une equipement
     *
     * @Route("/{id}/delete", name="editeur_equipement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Equipement $equipement)
    {
        $form = $this->createDeleteForm($equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipement);
            $em->flush();
        }

        return $this->redirectToRoute('editeur');
    }

    /**
     * Créer un form pour effacer une equipement
     *
     * @param Equipement $equipement
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Equipement $equipement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('editeur_equipement_delete', array('id' => $equipement->getEquipementId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     *
     * @Route("/{id}/test", name="editeur_equipement_test")
     */
    public function equipementTestAction($id){

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT f.nom, e.nom as etab FROM AppBundle:Equipement f JOIN f.etablissement e WHERE f.equipementId = :id')->setMaxResults(10);
        $query->setParameter("id", $id);
        $equipement = $query->getResult();

        $response = new Response();
        $response->setContent(json_encode($equipement));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
