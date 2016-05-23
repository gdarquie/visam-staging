<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImportLab
 *
 * @ORM\Table(name="import_lab")
 * @ORM\Entity
 */
class ImportLab
{
    /**
     * @var string
     *
     * @ORM\Column(name="uai", type="string", length=45, nullable=true)
     */
    private $uai;

    /**
     * @var integer
     *
     * @ORM\Column(name="labo", type="integer", nullable=true)
     */
    private $labo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set uai
     *
     * @param string $uai
     *
     * @return ImportLab
     */
    public function setUai($uai)
    {
        $this->uai = $uai;

        return $this;
    }

    /**
     * Get uai
     *
     * @return string
     */
    public function getUai()
    {
        return $this->uai;
    }

    /**
     * Set labo
     *
     * @param integer $labo
     *
     * @return ImportLab
     */
    public function setLabo($labo)
    {
        $this->labo = $labo;

        return $this;
    }

    /**
     * Get labo
     *
     * @return integer
     */
    public function getLabo()
    {
        return $this->labo;
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
