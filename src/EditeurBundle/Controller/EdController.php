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

        $editForm = $this->createForm('EditeurBundle\Form\EdType', $ed, array(
            'etablissements' => $etablissements
        ));

        $editForm->handleRequest($request);
        /////
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // --------------------------
            //Ajout des établissements
            // --------------------------

            //s'il n'y en a qu'un, ajout automatique
            if(count($etablissements) == 1){

                $repository = $this->getDoctrine()->getRepository('AppBundle:Etablissement');
                $etablissement = $repository->findOneByEtablissementId($etablissements[0]['id']);

                $ed->addEtablissement($etablissement);
            }
            //sinon l'utilisateur choisit lui-même un établissement

            // --------------------------
            //Set année de la collecte
            // --------------------------
            //vérification qu'il y a une collecte active
            $query = $em->createQuery(
                'SELECT COUNT(c.collecteId) as nb FROM AppBundle:Collecte c WHERE c.active = true'
            );
            $checkCollecte = $query->getResult();
            $checkCollecte = $checkCollecte[0]['nb'];

            //s'il y a plus que 0 = il y a une collecte active donc je prends sa date
            if($checkCollecte > 0){
                $query = $em->createQuery(
                    'SELECT c.annee as annee FROM AppBundle:Collecte c WHERE c.active = true'
                );
            }
            else{
                $query = $em->createQuery(
                    'SELECT c.annee as annee FROM AppBundle:Collecte c WHERE c.complete = true ORDER BY c.annee DESC'
                );
                $query->setMaxResults(1);
            }
            $year = $query->getSingleResult();
            $year = $year['annee'];
            $ed->setAnneeCollecte($year);

            $now = new \DateTime();
            $ed->setDateCreation($now);
            $ed->setLastUpdate($now);

            $em->persist($ed);
            $em->flush();

            //Création et set de l'objetId
            $lastId = $ed->getEdId();
            $ed->setObjetId("E".$lastId);

            $em->persist($ed);
            $em->flush();

            $this->addFlash(
                'success',
                "L'école doctorale a bien été sauvegardée"
            );
            return $this->redirectToRoute('editeur');

        }

        return $this->render('EditeurBundle:Ed:new.html.twig', array(
            'ed' => $ed,
            'form' => $editForm->createView(),
            'etablissements' => $etablissements
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
            'etablissements' => $etablissements
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
