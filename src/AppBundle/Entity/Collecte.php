<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Axe
 *
 * @ORM\Table(name="collecte")
 * @ORM\Entity
 */
class Collecte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="collecte_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $collecteId;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee", type="integer", nullable=true, unique=true)
     */
    private $annee;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Etablissement", inversedBy="collecte")
     * @ORM\JoinTable(name="collecte_has_etablissement",
     *   joinColumns={
     *     @ORM\JoinColumn(name="collecte_id", referencedColumnName="collecte_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="etablissement_id", referencedColumnName="etablissement_id")
     *   }
     * )
     */
    private $etablissement;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $complete;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $date_creation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="datetime", nullable=false)
     */
    private $last_update;


    /**
     * @return int
     */
    public function getCollecteId()
    {
        return $this->collecteId;
    }

    /**
     * @param int $collecteId
     */
    public function setCollecteId($collecteId)
    {
        $this->collecteId = $collecteId;
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
     * @return int
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * @param int $annee
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $etablissement
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * @param mixed $complete
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param \DateTime $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param \DateTime $last_update
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;
    }



}