<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="formation_parcours")
 */
class FormationParcours{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Formation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
     * })
     */
    private $formation;

    /**
     * @var \AppBundle\Entity\Parcours
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Parcours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parcours_id", referencedColumnName="parcours_id")
     * })
     */
    private $parcours;

    /**
     * @ORM\Column(type="integer")
     */
    private $rang;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * @param mixed $formation
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;
    }

    /**
     * @return mixed
     */
    public function getParcours()
    {
        return $this->parcours;
    }

    /**
     * @param mixed $parcours
     */
    public function setParcours($parcours)
    {
        $this->parcours = $parcours;
    }

    /**
     * @return mixed
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * @param mixed $rang
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
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