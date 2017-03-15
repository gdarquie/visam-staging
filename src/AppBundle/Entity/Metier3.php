<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Metier3
 *
 * @ORM\Table(name="metier3")
 * @ORM\Entity
 */
class Metier3
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=500)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="Metier2", inversedBy="metier3", cascade={"persist"})
     * @ORM\JoinColumn(name="metier2_id", referencedColumnName="id")
     */
    private $metier2;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getMetier2()
    {
        return $this->metier2;
    }

    /**
     * @param mixed $metier2
     */
    public function setMetier2($metier2)
    {
        $this->metier2 = $metier2;
    }





}
