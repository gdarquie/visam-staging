<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DiscForm
 *
 * @ORM\Table(name="disc_form")
 * @ORM\Entity
 */
class DiscForm
{
    /**
     * @var string
     *
     * @ORM\Column(name="formation", type="string", length=255, nullable=true)
     */
    private $formation;

    /**
     * @var string
     *
     * @ORM\Column(name="discipline", type="string", length=255, nullable=true)
     */
    private $discipline;

    /**
     * @var integer
     *
     * @ORM\Column(name="formation_id", type="integer", nullable=true)
     */
    private $formationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="discipline_id", type="integer", nullable=true)
     */
    private $disciplineId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set formation
     *
     * @param string $formation
     *
     * @return DiscForm
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation
     *
     * @return string
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Set discipline
     *
     * @param string $discipline
     *
     * @return DiscForm
     */
    public function setDiscipline($discipline)
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * Get discipline
     *
     * @return string
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * Set formationId
     *
     * @param integer $formationId
     *
     * @return DiscForm
     */
    public function setFormationId($formationId)
    {
        $this->formationId = $formationId;

        return $this;
    }

    /**
     * Get formationId
     *
     * @return integer
     */
    public function getFormationId()
    {
        return $this->formationId;
    }

    /**
     * Set disciplineId
     *
     * @param integer $disciplineId
     *
     * @return DiscForm
     */
    public function setDisciplineId($disciplineId)
    {
        $this->disciplineId = $disciplineId;

        return $this;
    }

    /**
     * Get disciplineId
     *
     * @return integer
     */
    public function getDisciplineId()
    {
        return $this->disciplineId;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
