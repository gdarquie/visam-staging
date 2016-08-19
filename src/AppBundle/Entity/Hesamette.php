<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="hesamette_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $hesametteId;


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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Hesamette
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
     * Get hesametteId
     *
     * @return integer
     */
    public function getHesametteId()
    {
        return $this->hesametteId;
    }

    public function __toString()
    {
        return (string) $this->getNom();
    }



}
