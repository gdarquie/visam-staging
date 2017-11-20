<?php

namespace EditeurBundle\Service;

class CollecteService
{
    public function test($test)
    {

        dump($test);die();

        return strtoupper($test);
    }
}