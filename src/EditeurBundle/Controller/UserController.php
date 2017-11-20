<?php

namespace EditeurBundle\Controller;

use AppBundle\Entity\User;
use EditeurBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
* Gestion des utilisateurs
*/
class UserController extends Controller
{

    /**
     *
     * @Route("/admin/user/{id}", name = "editeur_user_edit")
     */
    public function editUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($id);

        if (!is_object($user)) {
            throw new AccessDeniedException("Vous n'avez pas accès à cette section");
        }

        $editForm = $this->createForm('EditeurBundle\Form\UserType', $user, array());

        $editForm->handleRequest($request);

//        dump($editForm);die();

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin');

        }

        return $this->render('EditeurBundle:User:edit.html.twig', array(
            'id' => $id,
            'edit_form' => $editForm->createView()
        ));

    }

    /**
     * Fonction pour effacer via ajax un user
     *
     * @Route("/delete/{userId}", name="editeur_user_ajax_delete")
     * @Method("DELETE")
     */
    public function deleteAjaxAction($userId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if ($user->hasRole('ROLE_USER')){

            /** @var User $user */
            $user = $em->getRepository('AppBundle:User')
                ->find($userId);
            $em->remove($user);
            $em->flush();
        }


        return new Response(null, 204);


    }

}
