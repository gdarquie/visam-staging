<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Labo;
use EditeurBundle\Form\LaboType;


/**
 *
 * @Route("/editeur/laboratoire")
 */
class LaboratoireController extends Controller
{

    /**
     * Créer un laboratoire
     *
     * @Route("/new", name="editeur_laboratoire_new")
     */
    public function newLaboAction(Request $request){


        $laboratoire = new Labo();

        $em = $this->getDoctrine()->getManager();

        //ajout des établissements pour le formulaire
        $user = $this->getUser();
        if ($user->hasRole('ROLE_ADMIN')){
            $query = $em->createQuery(
                'SELECT e.etablissementId as id FROM AppBundle:Etablissement e'
            );
        }

        else{
            $userId = $user->getId();
            $query = $em->createQuery(
                'SELECT e.etablissementId as id FROM AppBundle:User u INNER JOIN u.etablissement e WHERE u.id = :user'
            );
            $query->setParameter('user', $userId);
        }
        $etablissements = $query->getResult();

        $editForm = $this->createForm('EditeurBundle\Form\LaboType', $laboratoire, array(
            'etablissements' => $etablissements
        ));

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
            'labo' => $laboratoire
        ));
    }

    /**
     * Editer un laboratoire
     *
     * @Route("/{id}/edit", name="editeur_laboratoire_edit")
     */
    public function editFormationAction(Request $request, Labo $laboratoire){

        $deleteForm = $this->createDeleteForm($laboratoire);

        $em = $this->getDoctrine()->getManager();

        //ajout des établissements pour le formulaire
        $user = $this->getUser();

        if ($user->hasRole('ROLE_ADMIN')){
            $query = $em->createQuery(
                'SELECT e.etablissementId as id FROM AppBundle:Etablissement e'
            );
        }

        else{
            $userId = $user->getId();
            $query = $em->createQuery(
                'SELECT e.etablissementId as id FROM AppBundle:User u INNER JOIN u.etablissement e WHERE u.id = :user'
            );
            $query->setParameter('user', $userId);
        }
        $etablissements = $query->getResult();

        $editForm = $this->createForm('EditeurBundle\Form\LaboType', $laboratoire, array(
            'etablissements' => $etablissements
        ));

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
     * Fonction pour effacer via ajax un labo
     *
     * @Route("/delete/{laboId}", name="editeur_laboratoire_ajax_delete")
     * @Method("DELETE")
     */
    public function deleteAjaxAction($laboId)
    {

        $em = $this->getDoctrine()->getManager();

        /** @var Labo $labo */
        $labo = $em->getRepository('AppBundle:Labo')
            ->find($laboId);
        $em->remove($labo);
        $em->flush();

        return new Response(null, 204);


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

//        return new Response(null, 204);
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
