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

        $query = $em->createQuery(
            'SELECT l.localisationId as id FROM AppBundle:Localisation l JOIN l.etablissement as e WHERE e.etablissementId IN (:etablissements)'
        );
        $query->setParameter('etablissements', $etablissements);
        $localisations = $query->getResult();

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

        $editForm = $this->createForm('EditeurBundle\Form\LaboType', $laboratoire, array(
            'etablissements' => $etablissements,
            'localisations' => $localisations
        ));

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // --------------------------
            //Ajout des établissements
            // --------------------------

            //s'il n'y en a qu'un, ajout automatique
            if(count($etablissements) == 1){

                $repository = $this->getDoctrine()->getRepository('AppBundle:Etablissement');
                $etablissement = $repository->findOneByEtablissementId($etablissements[0]['id']);

                $laboratoire->addEtablissement($etablissement);
            }
            //sinon l'utilisateur choisit lui-même un établissement

            if(count($localisations) == 1){

                $repository = $this->getDoctrine()->getRepository('AppBundle:Localisation');
                $localisation = $repository->findOneByLocalisationId($localisations[0]['id']);

                $laboratoire->addlocalisation($localisation);
            }

            $laboratoire->setAnneeCollecte($year);

            $now = new \DateTime();
            $laboratoire->setDateCreation($now);
            $laboratoire->setLastUpdate($now);

            $em->persist($laboratoire);
            $em->flush();

            //Création et set de l'objetId
            $lastId = $laboratoire->getLaboId();
            $laboratoire->setObjetId("L".$lastId);

//            dump($laboratoire);die();


            $em->persist($laboratoire);
            $em->flush();

            return $this->redirectToRoute('editeur');
        }

        return $this->render('EditeurBundle:Labo:new.html.twig', array(
            'edit_form' => $editForm->createView(),
            'labo' => $laboratoire,
            'etablissements' => $etablissements,
            'localisations' => $localisations,
            'year' => $year
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
                'SELECT e.etablissementId as id FROM AppBundle:Etablissement e JOIN e.collecte c WHERE c.active = 1 '
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

        //vérification que l'utilisateur peut modifier cette formation

        //Sélection de tous les établissements rattachés à la formation
        $query = $em->createQuery("SELECT e.etablissementId as id FROM AppBundle:Etablissement e JOIN e.labo f WHERE f.laboId = :id");
        $query->setParameter('id', $laboratoire->getLaboId());
        $etab_user = $query->getResult();

        //vérification que les établissement de la formation sont bien dans ceux du user

        $checkUser = [];

        for ($i = 0; $i < count($etablissements); $i++){

            for($j = 0; $j < count($etab_user);$j++){
                if($etablissements[$i] == $etab_user[$j]){
//                    dump($etablissements[$i]);
//                    dump($etab_user[$j]);
                    array_push($checkUser,$etab_user[$j]);
                }

            }
        }

        //si l'utilisateur a l'établissement de la formation dans sa liste
        if(count($checkUser) > 0) {

            $query = $em->createQuery(
                'SELECT l.localisationId as id FROM AppBundle:Localisation l JOIN l.etablissement as e WHERE e.etablissementId IN (:etablissements)'
            );
            $query->setParameter('etablissements', $etablissements);
            $localisations = $query->getResult();


            $editForm = $this->createForm('EditeurBundle\Form\LaboType', $laboratoire, array(
                'etablissements' => $etablissements,
                'localisations' => $localisations
            ));

            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {

                $laboratoire = $editForm->getData();
                $em = $this->getDoctrine()->getManager();

                $now = new \DateTime();
                $laboratoire->setLastUpdate($now);

//                dump($laboratoire);die();

                $em->persist($laboratoire);
                $em->flush();

                return $this->redirectToRoute('labo', array('id' => $laboratoire->getLaboId()));
            }

            return $this->render('EditeurBundle:Labo:edit.html.twig', array(
                'labo' => $laboratoire,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'etablissements' => $etablissements,
                'localisations' => $localisations
            ));
        }
        else{
            $this->addFlash('success', "Vous ne pouvez modifier ce laboratoire, vous n'êtes pas rattaché à l'établissement auquel il appartient");
            return $this->redirectToRoute('labo', array('id' => $laboratoire->getLaboId()));
        }
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
        $user = $this->getUser();

        if ($user->hasRole('ROLE_USER')){

            /** @var Labo $labo */
            $labo = $em->getRepository('AppBundle:Labo')
                ->find($laboId);
            $em->remove($labo);
            $em->flush();
        }


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
