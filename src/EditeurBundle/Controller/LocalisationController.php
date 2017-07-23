<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Localisation;

/**
 *
 * @Route("/editeur/localisation")
 */
class LocalisationController extends Controller
{
    /**
     * Créer une localisation
     *
     * @Route("/new", name="editeur_localisation_new")
     */
    public function newLocalisationAction(Request $request){

        $localisation = new Localisation();

        $form = $this->createForm('EditeurBundle\Form\LocalisationType', $localisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $localisation = $form->getData();
            $em = $this->getDoctrine()->getManager();


            $now = new \DateTime();
            $localisation->setTimestamp($now);

            $em->persist($localisation);
            $em->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('EditeurBundle:Localisation:new.html.twig', array(
            'edit_form' => $form->createView(),
            'localisation' => $localisation,
            // 'delete_form' => $deleteForm->createView(),
        ));
    }


    // à reprendre
    /**
     * Editer une localisation
     *
     * @Route("/{id}/edit", name="editeur_localisation_edit")
     */
    public function editLocalisationAction(Request $request, Localisation $localisation){

        $deleteForm = $this->createDeleteForm($localisation);
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


        //vérification que l'utilisateur peut modifier cette localisation

        //Sélection de tous les établissements rattachés à la localisation
        $query = $em->createQuery("SELECT e.etablissementId as id FROM AppBundle:Etablissement e JOIN e.localisation f WHERE f.localisationId = :id");
        $query->setParameter('id', $localisation->getLocalisationId());
        $etab_user = $query->getResult();

        //vérification que les établissement de la localisation sont bien dans ceux du user

        $checkUser = [];

        if ($user->hasRole('ROLE_ADMIN')){
            $checkUser = ['all'];
        }
        else{
            for ($i = 0; $i < count($etablissements); $i++){

                for($j = 0; $j < count($etab_user);$j++){
                    if($etablissements[$i] == $etab_user[$j]){
                        //                    dump($etablissements[$i]);
                        //                    dump($etab_user[$j]);
                        array_push($checkUser,$etab_user[$j]);
                    }

                }
            }
        }

        //si l'utilisateur a l'établissement de la localisation dans sa liste
        if(count($checkUser) > 0) {

            $query = $em->createQuery(
                'SELECT l.localisationId as id FROM AppBundle:Localisation l JOIN l.etablissement as e WHERE e.etablissementId IN (:etablissements)'
            );
            $query->setParameter('etablissements', $etablissements);
            $localisations = $query->getResult();

            $editForm = $this->createForm('EditeurBundle\Form\LocalisationType', $localisation, array(
                'etablissements' => $etablissements,
                'localisations' => $localisations
            ));

            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $now = new \DateTime();
                $localisation->setLastUpdate($now);

                $em->persist($localisation);
                $em->flush();

                return $this->redirectToRoute('localisation', array('id' => $localisation->getLocalisationId()));

            }

            return $this->render('EditeurBundle:Localisation:edit.html.twig', array(
                'localisation' => $localisation,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'etablissements' => $etablissements,
                'localisations' => $localisations
            ));
        }
        else{
            $this->addFlash('success', "Vous ne pouvez modifier cette localisation, vous n'êtes pas rattaché à l'établissement auquelle elle appartient");
            return $this->redirectToRoute('localisation', array('id' => $localisation->getLocalisationId()));
        }
    }


    /**
     * Fonction pour effacer via ajax une localisation
     *
     * @Route("/delete/{localisationId}", name="editeur_localisation_test_ajax_delete")
     * @Method("GET")
     */
    public function deleteTestAjaxAction($localisationId)
    {

        $em = $this->getDoctrine()->getManager();

        /** @var Localisation $localisation */
        $localisation = $em->getRepository('AppBundle:Localisation')
            ->find($localisationId);
        $em->remove($localisation);
        $em->flush();

        return new Response(null, 204);

    }

    /**
     * Fonction pour effacer via ajax une localisation
     *
     * @Route("/delete/{localisationId}", name="editeur_localisation_ajax_delete")
     * @Method("DELETE")
     */
    public function deleteAjaxAction($localisationId)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if ($user->hasRole('ROLE_USER')){

            /** @var Localisation $localisation */
            $localisation = $em->getRepository('AppBundle:Localisation')
                ->find($localisationId);
            $em->remove($localisation);
            $em->flush();
        }

        return new Response(null, 204);

    }

    /**
     * Effacer une localisation
     *
     * @Route("/{id}/delete", name="editeur_localisation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Localisation $localisation)
    {
        $form = $this->createDeleteForm($localisation);
        $form->handleRequest($request);

        //vérifier que l'user est bien un admin

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($localisation);
            $em->flush();
        }

        return $this->redirectToRoute('editeur');
    }

    /**
     * Créer un form pour effacer une localisation
     *
     * @param Localisation $localisation
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Localisation $localisation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('editeur_localisation_delete', array('id' => $localisation->getLocalisationId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     *
     * @Route("/{id}/test", name="editeur_localisation_test")
     */
    public function localisationTestAction($id){

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT f.nom, e.nom as etab FROM AppBundle:Localisation f JOIN f.etablissement e WHERE f.localisationId = :id')->setMaxResults(10);
        $query->setParameter("id", $id);
        $localisation = $query->getResult();

        $response = new Response();
        $response->setContent(json_encode($localisation));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
