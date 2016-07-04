<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImportTags
 *
 * @ORM\Table(name="import_tags")
 * @ORM\Entity
 */
class ImportTags
{
    /**
     * @var string
     *
     * @ORM\Column(name="uai", type="string", length=255, nullable=true)
     */
    private $uai;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="text", length=65535, nullable=true)
     */
    private $tag;

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
     * @return ImportTags
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
     * Set code
     *
     * @param string $code
     *
     * @return ImportTags
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
     * Set tag
     *
     * @param string $tag
     *
     * @return ImportTags
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
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
