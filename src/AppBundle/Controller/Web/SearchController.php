<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * Créer une collecte
     *
     * @Route("/", name="search_v2")
     */
    public function indexAction()
    {
        return $this->render('@App/search/search.html.twig', array(

        ));
    }
}
