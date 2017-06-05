<?php

namespace EditeurBundle\Controller;

use EditeurBundle\Service\CollecteService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Etablissement;
use AppBundle\Entity\Collecte;
use AppBundle\Entity\Labo;
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

            return $this->redirectToRoute('admin');
        }

        return $this->render('EditeurBundle:Collecte:edit.html.twig', array(
            'collecte' => $collecte,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Lancer la première collecte
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

    /**
     * Lancer une collecte
     *
     * @Route("/start/{collecteId}", name="editeur_collecte_start")
     */
    public function launchCollecteAction($collecteId)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Collecte');
        $collecte = $repository->findOneByCollecteId($collecteId);


        //Vérification si la collecte est active ou a déjà été complétée

        $active = $collecte->getActive();
        $complete = $collecte->getComplete();

        if ($active || $complete) {
            $this->addFlash('success', "La collecte est déjà active ou a déjà été finalisée");
            return $this->redirectToRoute('admin');
        } //Activation de la collecte
        else {

            //Selection des éléments de la précédente collecte

            //Séléction de la dernière collecte complétée
            $query = $em->createQuery(
                'SELECT c FROM AppBundle:Collecte c WHERE c.complete = true AND c.active = false ORDER BY c.annee DESC'
            );
            $query->setMaxResults(1);
            $lastCompleteCollecte = $query->getSingleResult();
            $annee = $lastCompleteCollecte->getAnnee();

            //Création des éléments de la nouvelle collecte

            //Sélection de tous les labos avec la date de collecte (conditionner aux seuls établissement sélectionnés par la collecte)
            $query = $em->createQuery(
                'SELECT l FROM AppBundle:Labo l WHERE l.anneeCollecte = :annee'
            );
            $query->setParameter('annee', $annee);
            $labos = $query->getResult();

//                dump($labos);die();

            //Sélection des formations (conditionner aux seuls établissement sélectionnés par la collecte)
            $query = $em->createQuery(
                'SELECT f FROM AppBundle:Formation f WHERE f.anneeCollecte = :annee'
            );
            $query->setParameter('annee', $annee);
            $formations = $query->getResult();

            //Sélection des écoles doctorales

            //Calcul de l'année de collecte
            $anneeNouvelleCollecte = $annee + 1;

            //Récupération de la date
            $now = new \DateTime();

            //Duplication de chaque élément
            foreach ($labos as $labo) {

                $id = $labo->getLaboId();
                $labo->setAnneeCollecte($anneeNouvelleCollecte);
                $labo->setDateCreation($now);
                $labo->setLastUpdate($now);

                //retrouver l'établissement du labo
                $query = $em->createQuery(
                    'SELECT e.etablissementId FROM AppBundle:Etablissement e JOIN e.labo l WHERE l.laboId = :id '
                );
                $query->setParameter('id', $id);
                $etablissements = $query->getResult();

                $repository = $this->getDoctrine()->getRepository('AppBundle:Etablissement');

                foreach ($etablissements as $item){
                    $etablissement = $repository->findOneByEtablissementId($item['etablissementId']);
                    $etablissement->addLabo($labo);
                }

                //Correction des disciplines

                //remplacer par un service
                $query = $em->createQuery(
                    'SELECT d FROM AppBundle:Discipline d JOIN d.labo l WHERE d.type = :type AND l.laboId = :id'
                );
                $query->setParameter('type', 'cnu');
                $query->setParameter('id', $id);
                $cnu = $query->getResult();
                $labo->setCnu($cnu);

                $query = $em->createQuery(
                    'SELECT d FROM AppBundle:Discipline d JOIN d.labo l WHERE d.type = :type AND l.laboId = :id'
                );
                $query->setParameter('type', 'sise');
                $query->setParameter('id', $id);
                $sise = $query->getResult();
                $labo->setSise($sise);

                $query = $em->createQuery(
                    'SELECT d FROM AppBundle:Discipline d JOIN d.labo l WHERE d.type = :type AND l.laboId = :id'
                );
                $query->setParameter('type', 'hceres');
                $query->setParameter('id', $id);
                $hceres = $query->getResult();
                $labo->setHceres($hceres);

                $em->detach($labo);
                $em->persist($labo);

            }


            foreach ($formations as $formation) {

                $id = $formation->getFormationId();
                $formation->setAnneeCollecte($anneeNouvelleCollecte);
                $formation->setDateCreation($now);
                $formation->setLastUpdate($now);

                //retrouver l'établissement d'une formation
                $query = $em->createQuery(
                    'SELECT e.etablissementId FROM AppBundle:Etablissement e JOIN e.formation l WHERE l.formationId = :id '
                );
                $query->setParameter('id', $id);
                $etablissements = $query->getResult();

                $repository = $this->getDoctrine()->getRepository('AppBundle:Etablissement');

                foreach ($etablissements as $item){
                    $etablissement = $repository->findOneByEtablissementId($item['etablissementId']);
                    $etablissement->addFormation($formation);
                }

                //Correction des disciplines

                //remplacer par un service
                $query = $em->createQuery(
                    'SELECT d FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type = :type AND f.formationId = :id'
                );
                $query->setParameter('type', 'cnu');
                $query->setParameter('id', $id);
                $cnu = $query->getResult();
                $formation->setCnu($cnu);

                $query = $em->createQuery(
                    'SELECT d FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type = :type AND f.formationId = :id'
                );
                $query->setParameter('type', 'sise');
                $query->setParameter('id', $id);
                $sise = $query->getResult();
                $formation->setSise($sise);

                $query = $em->createQuery(
                    'SELECT d FROM AppBundle:Discipline d JOIN d.formation f WHERE d.type = :type AND f.formationId = :id'
                );
                $query->setParameter('type', 'hceres');
                $query->setParameter('id', $id);
                $hceres = $query->getResult();
                $formation->setHceres($hceres);

                $em->detach($formation);
                $em->persist($formation);

            }

            //rendre la collecte active
            $collecte->setActive(true);
            $em->flush();

            $this->addFlash('success', "Ajout des labos et des formations effectué, la collecte est maintenant active");
            return $this->redirectToRoute('admin');

        }

    }


    /**
     * Clôturer une collecte
     *
     * @Route("/close/{collecteId}", name="editeur_collecte_close")
     */
    public function closeCollecteAction($collecteId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Collecte');
        $collecte = $repository->findOneByCollecteId($collecteId);
        $active = $collecte->getActive();

        if ($user->hasRole('ROLE_ADMIN')) {

            if ($active) {
                $query = $em->createQuery(
                    'UPDATE AppBundle:Collecte c SET c.active = 0, c.complete = 1 WHERE c.collecteId = :id'
                );
                $query->setParameter('id', $collecteId);
                $query->execute();

                $this->addFlash('success', "Féciliciations, la collecte est à présent achevée");
                return $this->redirectToRoute('admin');

            }
            else {
                $this->addFlash('success', "La collecte n'est pas active");
                return $this->redirectToRoute('admin');
            }
        }
    }

}//fin du controller
