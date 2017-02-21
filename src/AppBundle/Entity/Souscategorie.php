<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Souscategorie
 *
 * @ORM\Table(name="souscategorie")
 * @ORM\Entity
 */
class Souscategorie
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

    /*
     * @ORM\OneToMany(targetEntity="Metier", mappedBy="souscategorie")
     */
   // private $metiers;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="souscategories", cascade={"persist"})
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     */
    private $categorie;


    public function __construct()
    {
        $this->metiers = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Souscategorie
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Souscategorie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add metier
     *
     * @param \AppBundle\Entity\Metier $metier
     *
     * @return Souscategorie
     */
    public function addMetier(\AppBundle\Entity\Metier $metier)
    {
        $this->metiers[] = $metier;

        return $this;
    }

    /**
     * Remove metier
     *
     * @param \AppBundle\Entity\Metier $metier
     */
    public function removeMetier(\AppBundle\Entity\Metier $metier)
    {
        $this->metiers->removeElement($metier);
    }

    /**
     * Get metiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMetiers()
    {
        return $this->metiers;
    }

    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\Categorie $categorie
     *
     * @return Souscategorie
     */
    public function setCategorie(\AppBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \AppBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
