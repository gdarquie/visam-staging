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
     * Constructor
     */
    public function __construct()
    {
        $this->formation = new \Doctrine\Common\Collections\ArrayCollection();
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
}
