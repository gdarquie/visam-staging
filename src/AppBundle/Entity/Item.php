<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

//essayer de combiner labo, formation et plus tard ED dans la même table

/**
 * @ORM\Entity
 * @ORM\Table(name="item")
 */
class Item
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

}