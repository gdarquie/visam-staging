<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImportFormdisc
 *
 * @ORM\Table(name="import_formDisc")
 * @ORM\Entity
 */
class ImportFormdisc
{
    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=10, nullable=true)
     */
    private $niveau;

    /**
     * @var string
     *
     * @ORM\Column(name="discipline", type="string", length=500, nullable=true)
     */
    private $discipline;

    /**
     * @var string
     *
     * @ORM\Column(name="formation", type="string", length=255, nullable=true)
     */
    private $formation;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set niveau
     *
     * @param string $niveau
     *
     * @return ImportFormdisc
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set discipline
     *
     * @param string $discipline
     *
     * @return ImportFormdisc
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
     * Set formation
     *
     * @param string $formation
     *
     * @return ImportFormdisc
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
