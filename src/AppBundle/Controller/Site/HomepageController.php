<?php

namespace AppBundle\Controller\Site;

use AppBundle\Component\Stats\HandlerStats;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $hesamettes = $em->getRepository('AppBundle:Hesamette')->findAll();
        $stats = (new HandlerStats())->generalStats($em);

        return $this->render('web/index.html.twig', array(
            'hesamettes' => $hesamettes,
            'stats' => $stats
        ));
    }

}


