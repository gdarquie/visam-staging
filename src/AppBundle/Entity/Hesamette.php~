<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Hesamette
 *
 * @ORM\Table(name="hesamette")
 * @ORM\Entity
 */
class Hesamette
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=500, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="hesamette_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $hesametteId;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Discipline", mappedBy="hesamette_id")
     */
    private $disciplines;

    public function __construct()
    {
        $this->disciplines = new ArrayCollection();
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Hesamette
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
     * Get hesametteId
     *
     * @return integer
     */
    public function getHesametteId()
    {
        return $this->hesametteId;
    }

    /**
     * Add discipline
     *
     * @param \AppBundle\Entity\Discipline $discipline
     *
     * @return Hesamette
     */
    public function addDiscipline(\AppBundle\Entity\Discipline $discipline)
    {
        $this->disciplines[] = $discipline;

        return $this;
    }

    /**
     * Remove discipline
     *
     * @param \AppBundle\Entity\Discipline $discipline
     */
    public function removeDiscipline(\AppBundle\Entity\Discipline $discipline)
    {
        $this->disciplines->removeElement($discipline);
    }

    /**
     * Get disciplines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }
}
