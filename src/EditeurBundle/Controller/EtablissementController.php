<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Etablissement;
use EditeurBundle\Form\EtablissementType;

/**
 *
 * @Route("/admin/etablissement")
 */
class EtablissementController extends Controller
{

    /**
     * Créer un établissement
     *
     * @Route("/new", name="editeur_etablisement_new")
     */
    public function newAction(Request $request){

        $etablissement = new Etablissement();

        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $etablissement = $form->getData();

            $etablissement->setActive(true);

            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('EditeurBundle:Etablissement:new.html.twig', array(
            'etablissementForm' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit" , name = "editeur_etablissement_edit")
     */
    public function editAction(Request $request, Etablissement $etablissement, $id){

        $deleteForm = $this->createDeleteForm($etablissement);
        $etablissementForm = $this->createForm('EditeurBundle\Form\EtablissementType', $etablissement);
        $etablissementForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $etablissement = $em->getRepository('AppBundle:Etablissement')->findOneByEtablissementId($id);

        if ($etablissementForm->isSubmitted() && $etablissementForm->isValid()){
            // dump($form->getData());die;

            $etablissement = $etablissementForm->getData();
            $now = new \DateTime();
            $etablissement->setLastUpdate($now);


            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('EditeurBundle:Etablissement:edit.html.twig', array(
            'etablissementForm' => $etablissementForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'etablissement' => $etablissement
        ));
    }


    /**
     * Effacer un établissement
     *
     * @Route("/{id}/delete", name="editeur_etablissement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etablissement $etablissement)
    {
        $form = $this->createDeleteForm($etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('admin');
    }

    /**
     * Créer un form pour effacer un établissement
     *
     * @param Etablissement $etablissement
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Etablissement $etablissement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('editeur_etablissement_delete', array('id' => $etablissement->getEtablissementId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Fonction pour effacer via ajax un établissement
     *
     * @Route("/delete/{etablissementId}", name="editeur_etablissement_ajax_delete")
     * @Method("DELETE")
     */
    public function deleteAjaxAction($etablissementId)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if ($user->hasRole('ROLE_USER')){

            /** @var Etablissement $etablissementId */
            $etablissement = $em->getRepository('AppBundle:Etablissement')
                ->find($etablissementId);
            $em->remove($etablissement);
            $em->flush();
        }

        return new Response(null, 204);

    }

}





