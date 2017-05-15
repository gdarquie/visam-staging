<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Collecte;
use EditeurBundle\Form\CollecteType;

/**
 *
 * @Route("/admin/collecte")
 */
class CollecteController extends Controller
{
    /**
     * Créer une collecte
     *
     * @Route("/new", name="editeur_collecte_new")
     */
    public function newCollecteAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $collecte = new Collecte();

        //Pour sauvegarder une nouvelle collecte, création automatique de la nouvelle année de collecte - les collectes ont lieu tous les ans une fois par an

        //Définition de la nouvelle année de collecte

        //Vérification si des collectes existent déjà
        $query = $em->createQuery(
            'SELECT COUNT(c.collecteId) as annee FROM AppBundle:Collecte c ORDER BY c.annee DESC'
        )->setMaxResults(1);
        $check_collecte = $query->getSingleResult();

        //S'il y a déjà une collecte dans la BD :
        if($check_collecte['annee'] > 0){
        // 1. on vérifie qu'il n'y a plus de collecte active
            $query = $em->createQuery(
                'SELECT COUNT(c.collecteId) as nb FROM AppBundle:Collecte c WHERE c.active = :actif'
            )
                ->setParameter('actif', true)
                ->setMaxResults(1);
            $check_actif = $query->getSingleResult();

            //S'il y a une collecte active on stoppe la création de la collecte
            if($check_actif['nb'] > 0){
                //return / message d'erreur : "Une autre collecte est toujours active, veuillez la clore avant de procéder à la suivante'
                //redirection vers admin avec un message flash
                return $this->redirectToRoute('admin');
            }
            //S'il n'y a pas de collecte déjà active
            else{
                // 2. l'année la plus grande est prise en compte, on y ajoute 1
                $query = $em->createQuery(
                    'SELECT MAX(c.annee) as an FROM AppBundle:Collecte c ORDER BY c.annee DESC'
                )->setMaxResults(1);
                $annee = $query->getSingleResult();
                $annee = $annee['an'];
            }
        }
        //Si aucune collecte n'existe on pré-rempli le formulaire avec l'année en cours
        else{
            $annee = new \DateTime();
            $annee = $annee->format('Y');
        }

        $collecte->setAnnee($annee);
        $collecte->setActive(false);
        $collecte->setComplete(false);

        $editForm = $this->createForm('EditeurBundle\Form\CollecteType', $collecte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $collecte = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $collecte->setDateCreation($now);
            $collecte->setLastUpdate($now);

            $em->persist($collecte);
            $em->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('EditeurBundle:Collecte:new.html.twig', array(
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Editer une collecte
     *
     * @Route("/{collecteId}/edit", name="editeur_collecte_edit")
     */
    public function editFormationAction(Request $request, Collecte $collecte){

        $editForm = $this->createForm('EditeurBundle\Form\CollecteType', $collecte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $collecte = $editForm->getData();
            $em = $this->getDoctrine()->getManager();

            $now = new \DateTime();
            $collecte->setLastUpdate($now);

            $em->persist($collecte);
            $em->flush();

            return $this->redirectToRoute('collecte', array('id' => $collecte->getCollecteId() ));
        }

        return $this->render('EditeurBundle:Collecte:edit.html.twig', array(
            'collecte' => $collecte,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Lancer la première collecte collecte
     *
     * @Route("/init", name="editeur_collecte_init")
     */
    public function firstCollecteAction(){

        $em = $this->getDoctrine()->getManager();

        //vérifier qu'aucune collecte n'existe
        $query = $em->createQuery(
            'SELECT COUNT(c.collecteId) as nb FROM  AppBundle:Collecte c'
        );
        $check_collecte = $query->getSingleResult();

        //si une collecte existe déjà, on annule tout
        if($check_collecte['nb']> 0){
            $this->addFlash('success', "Une collecte a déjà été faite!");
            return $this->redirectToRoute('admin');
        }

        //sinon on crée la collecte initiale
        else{

            //année par défaut de la première collecte
            $annee = 2016;
            $now = new \DateTime();

            //Update tous les labos
            $query = $em->createQuery(
                'UPDATE AppBundle:Formation f SET f.anneeCollecte = :annee, f.last_update = :now'
            );
            $query->setParameter(':annee', $annee);
            $query->setParameter(':now', $now);
            $query->execute();

            //Update tous les formations
            $query = $em->createQuery(
                'UPDATE AppBundle:Labo l SET l.anneeCollecte = :annee, l.last_update = :now'
            );
            $query->setParameter(':annee', $annee);
            $query->setParameter(':now', $now);
            $query->execute();

            //Update tous les eds
            $query = $em->createQuery(
                'UPDATE AppBundle:Ed e SET e.anneeCollecte = :annee, e.last_update = :now'
            );
            $query->setParameter(':annee', $annee);
            $query->setParameter(':now', $now);
            $query->execute();

            //Créer une collecte 2016

            $nom= "L'incroyable collecte de 2016";

            $query = $em->createQuery(
                'SELECT e FROM  AppBundle:Etablissement e'
            );
            $etablissements = $query->getResult();

            $collecte = new Collecte();
            $collecte->setNom($nom);
            $collecte->setAnnee($annee);
            $collecte->setActive(false);
            $collecte->setComplete(true);
            $collecte->setEtablissement($etablissements);

            $collecte->setDateCreation($now);
            $collecte->setLastUpdate($now);

            $em->persist($collecte);
            $em->flush();

            $this->addFlash('success', "La collecte a bien été réalisée");
            return $this->redirectToRoute('admin');
        }


    }

}
