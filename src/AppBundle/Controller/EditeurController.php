<?php

namespace AppBundle\Controller;

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

        return $this->render('editeur/index.html.twig');
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
* Les laboratoires
*
/**   

    /**
     * Editer un laboratoire
     *
     * @Route("/labo/{id}/edit", name="editeur_labo_edit")
     * @Method("GET")
     */
    public function editLaboAction(Request $request, Labo $labo){

        // $deleteForm = $this->createDeleteLaboForm($labo);
        $editForm = $this->createForm('AppBundle\Form\LaboType', $labo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($labo);
            $em->flush();

            return $this->redirectToRoute('editeur_labo_edit', array('id' => $labo->getLaboId()));
        }

        return $this->render('editeur/labo/edit.html.twig', array(
            'labo' => $labo,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
            ));
    }

/**
*
* Les formations
*
/**   

    /**
     * Editer une formation
     *
     * @Route("/formation/{id}/edit", name="editeur_formation_edit")
     * @Method("GET")
     */
    public function editFormationAction(Request $request, Formation $formation){

        // $deleteForm = $this->createDeleteLaboForm($labo);
        $editForm = $this->createForm('AppBundle\Form\FormationType', $formation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('editeur_formation_edit', array('id' => $formation->getFormationId()));
        }

        return $this->render('editeur/formation/edit.html.twig', array(
            'formation' => $formation,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
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


/**
*
* Les établissements
*
/**


    /**
     * Lists all Etablissement entities.
     *
     * @Route("/etablissement/", name="etab_index")
     * @Method("GET")
     */
    public function indexEtabAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('AppBundle:Etablissement')->findAll();

        return $this->render('editeur/etablissement/index.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }

    /**
     * Creates a new Etablissement entity.
     *
     * @Route("/etablissement/new", name="etab_new")
     * @Method({"GET", "POST"})
     */
    public function newEtabAction(Request $request)
    {
        $etablissement = new Etablissement();
        $form = $this->createForm('AppBundle\Form\EtablissementType', $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('etab_show', array('id' => $etablissement->getEtablissementId()));
        }

        return $this->render('editeur/etablissement/new.html.twig', array(
            'etablissement' => $etablissement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Etablissement entity.
     *
     * @Route("/etablissement/{id}", name="etab_show")
     * @Method("GET")
     */
    public function showEtabAction(Etablissement $etablissement)
    {
        $deleteForm = $this->createDeleteEtabForm($etablissement);

        return $this->render('editeur/etablissement/show.html.twig', array(
            'etablissement' => $etablissement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Etablissement entity.
     *
     * @Route("/etablissement/{id}/edit", name="etab_edit")
     * @Method({"GET", "POST"})
     */
    public function editEtabAction(Request $request, Etablissement $etablissement)
    {
        $deleteForm = $this->createDeleteEtabForm($etablissement);
        $editForm = $this->createForm('AppBundle\Form\EtablissementType', $etablissement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('etab_edit', array('id' => $etablissement->getEtablissementId()));
        }

        return $this->render('editeur/etablissement/edit.html.twig', array(
            'etablissement' => $etablissement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Etablissement entity.
     *
     * @Route("/etablissement/{id}", name="etab_delete")
     * @Method("DELETE")
     */
    public function deleteEtabAction(Request $request, Etablissement $etablissement)
    {
        $form = $this->createDeleteEtabForm($etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('etab_index');
    }

    /**
     * Creates a form to delete a Etablissement entity.
     *
     * @param Etablissement $etablissement The Etablissement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteEtabForm(Etablissement $etablissement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etab_delete', array('id' => $etablissement->getEtablissementId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
