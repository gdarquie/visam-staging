<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;;

class StatsThemesTestController extends Controller
{
    /**
     * @Route("/graphes/test1/test", name="stats_themes_1")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //nombre de formations par hesamettes
        $sql = "SELECT etab.nom, etab.sigle, COUNT(f.nom) as nb 
                FROM AppBundle:Etablissement etab
                JOIN etab.formation f
                JOIN f.discipline d
                ";
		
		$sql = "SELECT e.etablissementId as etab_id, e.nom, h.hesametteId as hesamette_id, h.nom as hesamette, COUNT(f) as nb FROM AppBundle:Discipline d JOIN d.formation f JOIN d.hesamette h JOIN f.etablissement e GROUP BY  e, h
                ";

        $query = $em->createQuery($sql);

        $formations = $query->getResult();
/*
		$etabid = '';
        $groups['name'] = 'Hesam';
        $groups['children'] = [];

		foreach ($formations as $cle => $val)  {
			if (isset($etabid) && $etabid != $val['etab_id']) {

                $childs['hesamette_id'] = $val['hesamette_id'];
                $childs['hesamette'] = $val['hesamette'];
                $childs['nb'] = $val['nb'];
                $etablissements['id'] = $val['etab_id'];
                $etablissements['nom'] = $val['nom'];
                $etablissements['children'] = [$childs];

                $etabid = $val['etab_id'];
            } else {

                $childs['hesamette_id'] = $val['hesamette_id'];
                $childs['hesamette'] = $val['hesamette'];
                $childs['nb'] = $val['nb'];
                $etablissements['children'] = array_push($etablissements['children'], $childs);
            }
           $groups['children'] = array_push( $groups['children'], $etablissements['children']);
		}
*/
        $formations = [
            "name" =>  'Hesam',
            "children" => [ 
							[
								"id" => 2,
								"name" => "CNAM2",
								"children" => [
									["id" => 1, "name" => "mATH", "size" => 52],
									["id" => 2, "name" => "PH", "size" => 152]
								]
							],
							[
								"id" => 3,
								"name" => "CNAM3",
								"children" => [
									["id" => 1, "name" => "mATH", "size" => 52],
									["id" => 2, "name" => "PH", "size" => 152]
								]
							],
							[
								"id" => 4,
								"name" => "CNAM4",
								"children" => [
									["id" => 1, "name" => "mATH", "size" => 52],
									["id" => 2, "name" => "PH", "size" => 152]
								]
							]
                        ]

        ];

       // dump($formations); die;

        //nombre de formations par hesamettes
        $sql = "SELECT etab.sigle, COUNT(l.nom) as nb 
                FROM AppBundle:Etablissement etab
                JOIN etab.labo l
                JOIN l.discipline d
                WHERE d.hesamette=:thematique
                GROUP BY etab
                ";

        $query = $em->createQuery($sql);
        $query->setParameter('thematique', 1);
        $labos = $query->getResult();
		

        return $this->render('web/stats/stats_effectif_test2.html.twig', array(

            'formations' =>json_encode($formations),
            'labos' => $labos,
        ));

    }
}