<?php

namespace AppBundle\Controller\Stats;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatsThemesController extends Controller
{
    /**
     * @Route("/graphes/{thematiques}", name="stats_themes")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // verifier si les thematiques existe
        //nombre de formations par hesamettes
        //effectifs
        $query = $em->createQuery('SELECT h.nom as hesamette, SUM(f.effectif) as nb, f.nom as formation FROM AppBundle:Discipline d JOIN d.formation f JOIN d.hesamette h GROUP BY h ORDER BY nb DESC');
        $effectifHesamette = $query->getResult();

        return $this->render('web/stats/stats_effectif.html.twig', array(
            'effHesamette' => $effectifHesamette,
        ));
    }
}