<?php

namespace AppBundle\Controller\Editeur;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Formation;
use AppBundle\Form\FormationType;

/**
 *
 * @Route("/editeur/formation")
 */
class FormationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * Créer une formation
     *
     * @Route("/new", name="editeur_formation_new")
     */
    public function newFormationAction(Request $request){

        // $deleteForm = $this->createDeleteLaboForm($labo);

        $formation = new Formation();
        $form = $this->createForm('AppBundle\Form\FormationType', $formation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $formation = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $formation->setDateCreation($now);
            $formation->setLastUpdate($now);

            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('editeur/formation/new.html.twig', array(
            'edit_form' => $form->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Editer une formation
     *
     * @Route("/{id}/edit", name="editeur_formation_edit")
     */
    public function editFormationAction(Request $request, Formation $formation){

        $deleteForm = $this->createDeleteForm($formation);
        $editForm = $this->createForm('AppBundle\Form\FormationType', $formation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $formation->setLastUpdate($now);

            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('formation', array('id' => $formation->getFormationId() ));

        }

        return $this->render('editeur/formation/edit.html.twig', array(
            'formation' => $formation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Effacer une formation
     *
     * @Route("/{id}/delete", name="editeur_formation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Formation $formation)
    {
        $form = $this->createDeleteForm($formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($formation);
            $em->flush();
        }

        return $this->redirectToRoute('editeur');
    }

    /**
     * Créer un form pour effacer une formation
     *
     * @param Formation $formation
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Formation $formation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('editeur_formation_delete', array('id' => $formation->getFormationId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     *
     * @Route("/{id}/test", name="editeur_formation_test")
     */
    public function formationTestAction($id){

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT f.nom, e.nom as etab FROM AppBundle:Formation f JOIN f.etablissement e WHERE f.formationId = :id')->setMaxResults(10);
        $query->setParameter("id", $id);
        $formation = $query->getResult();

        $response = new Response();
        $response->setContent(json_encode($formation));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
