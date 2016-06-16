<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImportLocetab
 *
 * @ORM\Table(name="import_locEtab")
 * @ORM\Entity
 */
class ImportLocetab
{
    /**
     * @var string
     *
     * @ORM\Column(name="loc", type="string", length=255, nullable=true)
     */
    private $loc;

    /**
     * @var integer
     *
     * @ORM\Column(name="etab", type="integer", nullable=true)
     */
    private $etab;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set loc
     *
     * @param string $loc
     *
     * @return ImportLocetab
     */
    public function setLoc($loc)
    {
        $this->loc = $loc;

        return $this;
    }

    /**
     * Get loc
     *
     * @return string
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * Set etab
     *
     * @param integer $etab
     *
     * @return ImportLocetab
     */
    public function setEtab($etab)
    {
        $this->etab = $etab;

        return $this;
    }

    /**
     * Get etab
     *
     * @return integer
     */
    public function getEtab()
    {
        return $this->etab;
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
