<?php

namespace AppBundle\Controller\Editeur;

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
        $editForm = $this->createForm('AppBundle\Form\LaboType', $laboratoire);
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

        return $this->render('editeur/labo/new.html.twig', array(
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Editer un laboratoire
     *
     * @Route("/{id}/edit", name="editeur_laboratoire_edit")
     */
    public function editFormationAction(Request $request, Labo $laboratoire){

        $editForm = $this->createForm('AppBundle\Form\LaboType', $laboratoire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $laboratoire = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $laboratoire->setLastUpdate($now);

            $em->persist($laboratoire);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('editeur/labo/edit.html.twig', array(
            'labo' => $laboratoire,
            'edit_form' => $editForm->createView()
        ));
    }


}
