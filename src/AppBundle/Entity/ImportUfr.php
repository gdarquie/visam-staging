<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImportUfr
 *
 * @ORM\Table(name="import_ufr")
 * @ORM\Entity
 */
class ImportUfr
{
    /**
     * @var string
     *
     * @ORM\Column(name="ufr", type="string", length=500, nullable=true)
     */
    private $ufr;

    /**
     * @var string
     *
     * @ORM\Column(name="formation", type="string", length=255, nullable=true)
     */
    private $formation;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255, nullable=true)
     */
    private $niveau;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set ufr
     *
     * @param string $ufr
     *
     * @return ImportUfr
     */
    public function setUfr($ufr)
    {
        $this->ufr = $ufr;

        return $this;
    }

    /**
     * Get ufr
     *
     * @return string
     */
    public function getUfr()
    {
        return $this->ufr;
    }

    /**
     * Set formation
     *
     * @param string $formation
     *
     * @return ImportUfr
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
     * Set niveau
     *
     * @param string $niveau
     *
     * @return ImportUfr
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
     * Set url
     *
     * @param string $url
     *
     * @return ImportUfr
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
