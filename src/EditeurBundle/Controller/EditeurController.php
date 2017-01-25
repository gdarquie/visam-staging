<?php

namespace AppBundle\Controller\Editeur;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ed;
use AppBundle\Entity\Etablissement;
use AppBundle\Entity\Formation;
use AppBundle\Entity\Labo;


/**
 * Editeur controller.
 *
 * @Route("/editeur")
 */
class EditeurController extends Controller
{

    /**
     * Accueil de l'éditeur
     *
     * @Route("/", name="editeur")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('AppBundle:Etablissement')->findAll();

        $query = $em->createQuery(
            'SELECT f FROM AppBundle:Formation f ORDER BY f.last_update DESC'
        )->setMaxResults(10);
        $formations = $query->getResult();

        $query = $em->createQuery(
            'SELECT l FROM AppBundle:Labo l ORDER BY l.last_update DESC'
        )->setMaxResults(10);
        $laboratoires = $query->getResult();


        return $this->render('editeur/index.html.twig', array(
            'etablissements' => $etablissements,
            'formations' => $formations,
            'laboratoires' => $laboratoires,
        ));
    }


    /**
     * Synthèse
     *
     * @Route("/synthese", name="editeur_synthese")
     * @Method("GET")
     */
    public function syntheseAction()
    {
        $em = $this->getDoctrine()->getManager();

        $max = 10;
        $offset = 10;

        $query = $em->createQuery(
            'SELECT f FROM AppBundle:Formation f'
        )->setMaxResults($max)->setFirstResult(10);

        $formations = $query->getResult();
        $labos = $em->getRepository('AppBundle:Labo')->findAll();
        $etabs = $em->getRepository('AppBundle:Etablissement')->findAll();

        return $this->render('editeur/synthese.html.twig', array(
            'labos' => $labos,
            'etabs' => $etabs,
            'formations' => $formations,
            ));
    }

/**
*
* Les écoles doctorales
*
/**

    /**
     * Lists all Ed entities.
     *
     * @Route("/ed/", name="ed_index")
     * @Method("GET")
     */
    public function allEdAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eds = $em->getRepository('AppBundle:Ed')->findAll();

        return $this->render('editeur/ed/index.html.twig', array(
            'eds' => $eds,
        ));
    }

    /**
     * Creates a new Ed entity.
     *
     * @Route("/ed/new", name="ed_new")
     * @Method({"GET", "POST"})
     */
    public function newEdAction(Request $request)
    {
        $ed = new Ed();
        $form = $this->createForm('AppBundle\Form\EdType', $ed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ed);
            $em->flush();

            return $this->redirectToRoute('ed_show', array('id' => $ed->getEdId()));
        }

        return $this->render('editeur/ed/new.html.twig', array(
            'ed' => $ed,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ed entity.
     *
     * @Route("/ed/{id}", name="ed_show")
     * @Method("GET")
     */
    public function showEdAction(Ed $ed)
    {
        $deleteForm = $this->createDeleteEdForm($ed);

        return $this->render('editeur/ed/show.html.twig', array(
            'ed' => $ed,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ed entity.
     *
     * @Route("/ed/{id}/edit", name="ed_edit")
     * @Method({"GET", "POST"})
     */
    public function editEdAction(Request $request, Ed $ed)
    {
        $deleteForm = $this->createDeleteEdForm($ed);
        $editForm = $this->createForm('AppBundle\Form\EdType', $ed);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ed);
            $em->flush();

            return $this->redirectToRoute('ed_edit', array('id' => $ed->getEdId()));
        }

        return $this->render('editeur/ed/edit.html.twig', array(
            'ed' => $ed,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ed entity.
     *
     * @Route("/ed/{id}", name="ed_delete")
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

        return $this->redirectToRoute('ed_index');
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
            ->setAction($this->generateUrl('ed_delete', array('id' => $ed->getEdId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
