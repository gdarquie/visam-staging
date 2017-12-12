<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     *
     * @Route("/", name="search")
     */
    public function indexAction()
    {
        return $this->render('@App/search/search.html.twig', array(

        ));
    }

    /**
     * @Route("/iframe", name="search_iframe")
     */
    public function iframeAction()
    {
        return $this->render('@App/search/iframe.html.twig', array(

        ));
    }

}
