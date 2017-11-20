<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Metier2
 *
 * @ORM\Table(name="metier2")
 * @ORM\Entity
 */
class Metier2
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
     * @ORM\Column(name="code", type="string", length=5)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=500)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="Metier1", inversedBy="metier2", cascade={"persist"})
     * @ORM\JoinColumn(name="metier1_id", referencedColumnName="id")
     */
    private $metier1;

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
    public function getMetier1()
    {
        return $this->metier1;
    }

    /**
     * @param mixed $metier1
     */
    public function setMetier1($metier1)
    {
        $this->metier1 = $metier1;
    }

}
