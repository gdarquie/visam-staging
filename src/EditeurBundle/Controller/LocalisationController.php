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

            $this->addFlash(
                'success',
                "Une nouvelle localisation a bien été créée!"
            );

            return $this->redirectToRoute('admin');
        }

        return $this->render('EditeurBundle:Localisation:new.html.twig', array(
            'edit_form' => $form->createView(),
            'localisation' => $localisation,
            // 'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Editer une localisation
     *
     * @Route("/{id}/edit", name="editeur_localisation_edit")
     */
    public function editLocalisationAction(Request $request, Localisation $localisation){

        $deleteForm = $this->createDeleteForm($localisation);
        $em = $this->getDoctrine()->getManager();


        $form = $this->createForm('EditeurBundle\Form\LocalisationType', $localisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $localisation = $form->getData();
            $em = $this->getDoctrine()->getManager();


            $now = new \DateTime();
            $localisation->setTimestamp($now);

            $em->persist($localisation);
            $em->flush();

            $this->addFlash(
                'success',
                "Les changements ont été sauvegardés!"
            );

            return $this->redirectToRoute('admin');
        }

        return $this->render('EditeurBundle:Localisation:new.html.twig', array(
            'edit_form' => $form->createView(),
            'localisation' => $localisation,
             'delete_form' => $deleteForm->createView(),
        ));
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
