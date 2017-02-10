<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity()
 */
class Categorie
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


    /*
     * @ORM\OneToMany(targetEntity="Souscategorie", mappedBy="categorie")
     */
    /*
    private $souscategories;
*/
    /**
     * @ORM\ManyToOne(targetEntity="Secteur", inversedBy="categorie", cascade={"persist"})
     * @ORM\JoinColumn(name="secteur_id", referencedColumnName="id")
     */
    private $secteur;


    public function __construct()
    {
        $this->souscategories = new ArrayCollection();
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
     * @return Categorie
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
     * @return Categorie
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
     * Set secteur
     *
     * @param \AppBundle\Entity\Secteur $secteur
     *
     * @return Categorie
     */
    public function setSecteur(\AppBundle\Entity\Secteur $secteur = null)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get secteur
     *
     * @return \AppBundle\Entity\Secteur
     */
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * Set secteurs
     *
     * @param \AppBundle\Entity\Secteur $secteurs
     *
     * @return Categorie
     */
    public function setSecteurs(\AppBundle\Entity\Secteur $secteurs = null)
    {
        $this->secteurs = $secteurs;

        return $this;
    }

    /**
     * Get secteurs
     *
     * @return \AppBundle\Entity\Secteur
     */
    public function getSecteurs()
    {
        return $this->secteurs;
    }
}
