<?php

namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ItemController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    //get all items (labo + formation avec un responseJson
}


