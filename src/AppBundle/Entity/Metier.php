<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Metier
 *
 * @ORM\Table(name="metier")
 * @ORM\Entity
 */
class Metier
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="metier_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $metierId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Formation", mappedBy="metier")
     */
    private $formation;

    /**
     * @var string
     *
     * @ORM\Column(name="rome", type="string", length=20)
     */
    private $rome;

    /**
     * @ORM\ManyToOne(targetEntity="Souscategorie", inversedBy="metier")
     * @ORM\JoinColumn(name="souscategorie_id", referencedColumnName="id")
     */
    private $souscategorie;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime();
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Metier
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
     * Set description
     *
     * @param string $description
     *
     * @return Metier
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Metier
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Get metierId
     *
     * @return integer
     */
    public function getMetierId()
    {
        return $this->metierId;
    }

    /**
     * Add formation
     *
     * @param \AppBundle\Entity\Formation $formation
     *
     * @return Metier
     */
    public function addFormation(\AppBundle\Entity\Formation $formation)
    {
        $this->formation[] = $formation;

        return $this;
    }

    /**
     * Remove formation
     *
     * @param \AppBundle\Entity\Formation $formation
     */
    public function removeFormation(\AppBundle\Entity\Formation $formation)
    {
        $this->formation->removeElement($formation);
    }

    /**
     * Get formation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Set souscategorie
     *
     * @param \AppBundle\Entity\Souscategorie $souscategorie
     *
     * @return Metier
     */
    public function setSouscategorie(\AppBundle\Entity\Souscategorie $souscategorie = null)
    {
        $this->souscategorie = $souscategorie;

        return $this;
    }

    /**
     * Get souscategorie
     *
     * @return \AppBundle\Entity\Souscategorie
     */
    public function getSouscategorie()
    {
        return $this->souscategorie;
    }

    /**
     * Set rome
     *
     * @param string $rome
     *
     * @return Metier
     */
    public function setRome($rome)
    {
        $this->rome = $rome;

        return $this;
    }

    /**
     * Get rome
     *
     * @return string
     */
    public function getRome()
    {
        return $this->rome;
    }

    /**
     * Set souscategories
     *
     * @param \AppBundle\Entity\Souscategorie $souscategories
     *
     * @return Metier
     */
    public function setSouscategories(\AppBundle\Entity\Souscategorie $souscategories = null)
    {
        $this->souscategories = $souscategories;

        return $this;
    }

    /**
     * Get souscategories
     *
     * @return \AppBundle\Entity\Souscategorie
     */
    public function getSouscategories()
    {
        return $this->souscategories;
    }
}
