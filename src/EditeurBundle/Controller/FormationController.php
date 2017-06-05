<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Formation;

/**
 *
 * @Route("/editeur/formation")
 */
class FormationController extends Controller
{
    /**
     * Créer une formation
     *
     * @Route("/new", name="editeur_formation_new")
     */
    public function newFormationAction(Request $request){

        // $deleteForm = $this->createDeleteLaboForm($labo);

        $formation = new Formation();

        $em = $this->getDoctrine()->getManager();

        //ajout des établissements pour le formulaire
        $user = $this->getUser();

        //si l'utilisateur est administrateur, on lui ajoute tous les établissements
        if ($user->hasRole('ROLE_ADMIN')){
            $query = $em->createQuery(
                'SELECT e.etablissementId as id FROM AppBundle:Etablissement e'
            );
        }

        //sinon, on lui conditionne un établissement
        else{
            $userId = $user->getId();
            $query = $em->createQuery(
                'SELECT e.etablissementId as id FROM AppBundle:User u INNER JOIN u.etablissement e WHERE u.id = :user'
            );
            $query->setParameter('user', $userId);
        }
        $etablissements = $query->getResult();

        $form = $this->createForm('EditeurBundle\Form\FormationType', $formation, array(
            'etablissements' => $etablissements
        ));

//        $form = $this->createForm('EditeurBundle\Form\FormationType', $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formation = $form->getData();
            $em = $this->getDoctrine()->getManager();

            // --------------------------
            //Ajout des établissements
            // --------------------------

            //s'il n'y en a qu'un, ajout automatique
            if(count($etablissements) == 1){

                $repository = $this->getDoctrine()->getRepository('AppBundle:Etablissement');
                $etablissement = $repository->findOneByEtablissementId($etablissements[0]['id']);

                $formation->addEtablissement($etablissement);
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
            $formation->setAnneeCollecte($year);

            $now = new \DateTime();
            $formation->setDateCreation($now);
            $formation->setLastUpdate($now);

            $em->persist($formation);
            $em->flush();

            //Création et set de l'objetId
            $lastId = $formation->getFormationId();
            $formation->setObjetId("F".$lastId);

            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('EditeurBundle:Formation:new.html.twig', array(
            'edit_form' => $form->createView(),
            'formation' => $formation,
            'etablissements' => $etablissements
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

        $editForm = $this->createForm('EditeurBundle\Form\FormationType', $formation, array(
            'etablissements' => $etablissements
        ));

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $formation->setLastUpdate($now);

            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('formation', array('id' => $formation->getFormationId() ));

        }

        return $this->render('EditeurBundle:Formation:edit.html.twig', array(
            'formation' => $formation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'etablissements' => $etablissements
        ));
    }


    /**
     * Fonction pour effacer via ajax une formation
     *
     * @Route("/delete/{formationId}", name="editeur_formation_test_ajax_delete")
     * @Method("GET")
     */
    public function deleteTestAjaxAction($formationId)
    {

        $em = $this->getDoctrine()->getManager();

        /** @var Formation $formation */
        $formation = $em->getRepository('AppBundle:Formation')
            ->find($formationId);
        $em->remove($formation);
        $em->flush();

        return new Response(null, 204);

    }

    /**
     * Fonction pour effacer via ajax une formation
     *
     * @Route("/delete/{formationId}", name="editeur_formation_ajax_delete")
     * @Method("DELETE")
     */
    public function deleteAjaxAction($formationId)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if ($user->hasRole('ROLE_USER')){

            /** @var Formation $formation */
            $formation = $em->getRepository('AppBundle:Formation')
                ->find($formationId);
            $em->remove($formation);
            $em->flush();
        }

        return new Response(null, 204);

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

        //vérifier que l'user est bien un admin

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
