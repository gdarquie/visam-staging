<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtabForm
 *
 * @ORM\Table(name="etab_form")
 * @ORM\Entity
 */
class EtabForm
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="etablissement", type="integer", nullable=false)
     */
    private $etablissement;

    /**
     * @var integer
     *
     * @ORM\Column(name="formation", type="integer", nullable=false)
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
     * Set code
     *
     * @param string $code
     *
     * @return EtabForm
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
     * @return EtabForm
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
     * Set etablissement
     *
     * @param integer $etablissement
     *
     * @return EtabForm
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement
     *
     * @return integer
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Set formation
     *
     * @param integer $formation
     *
     * @return EtabForm
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation
     *
     * @return integer
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
