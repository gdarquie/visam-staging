<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Localisation
 *
 * @ORM\Table(name="localisation")
 * @ORM\Entity
 */
class Localisation
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=255, nullable=true)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="long", type="string", length=255, nullable=true)
     */
    private $long;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=500, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=30, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=500, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=500, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=500, nullable=true)
     */
    private $pays;

    /**
     * @var integer
     *
     * @ORM\Column(name="localisation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $localisationId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ufr", inversedBy="localisation")
     * @ORM\JoinTable(name="localisation_has_ufr",
     *   joinColumns={
     *     @ORM\JoinColumn(name="localisation_id", referencedColumnName="localisation_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ufr_id", referencedColumnName="ufr_id")
     *   }
     * )
     */
    private $ufr;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Labo", inversedBy="localisation")
     * @ORM\JoinTable(name="localisation_has_labo",
     *   joinColumns={
     *     @ORM\JoinColumn(name="localisation_id", referencedColumnName="localisation_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="labo_id", referencedColumnName="labo_id")
     *   }
     * )
     */
    private $labo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Formation", inversedBy="localisation")
     * @ORM\JoinTable(name="localisation_has_formation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="localisation_id", referencedColumnName="localisation_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
     *   }
     * )
     */
    private $formation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Etablissement", inversedBy="localisation")
     * @ORM\JoinTable(name="localisation_has_etablissement",
     *   joinColumns={
     *     @ORM\JoinColumn(name="localisation_id", referencedColumnName="localisation_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="etablissement_id", referencedColumnName="etablissement_id")
     *   }
     * )
     */
    private $etablissement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ed", inversedBy="localisation")
     * @ORM\JoinTable(name="localisation_has_ed",
     *   joinColumns={
     *     @ORM\JoinColumn(name="localisation_id", referencedColumnName="localisation_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ED_id", referencedColumnName="ED_id")
     *   }
     * )
     */
    private $ed;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ufr = new \Doctrine\Common\Collections\ArrayCollection();
        $this->labo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etablissement = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ed = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Localisation
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
     * Set lat
     *
     * @param string $lat
     *
     * @return Localisation
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set long
     *
     * @param string $long
     *
     * @return Localisation
     */
    public function setLong($long)
    {
        $this->long = $long;

        return $this;
    }

    /**
     * Get long
     *
     * @return string
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Localisation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Localisation
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Localisation
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Localisation
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return Localisation
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Localisation
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Get localisationId
     *
     * @return integer
     */
    public function getLocalisationId()
    {
        return $this->localisationId;
    }

    /**
     * Add ufr
     *
     * @param \AppBundle\Entity\Ufr $ufr
     *
     * @return Localisation
     */
    public function addUfr(\AppBundle\Entity\Ufr $ufr)
    {
        $this->ufr[] = $ufr;

        return $this;
    }

    /**
     * Remove ufr
     *
     * @param \AppBundle\Entity\Ufr $ufr
     */
    public function removeUfr(\AppBundle\Entity\Ufr $ufr)
    {
        $this->ufr->removeElement($ufr);
    }

    /**
     * Get ufr
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUfr()
    {
        return $this->ufr;
    }

    /**
     * Add labo
     *
     * @param \AppBundle\Entity\Labo $labo
     *
     * @return Localisation
     */
    public function addLabo(\AppBundle\Entity\Labo $labo)
    {
        $this->labo[] = $labo;

        return $this;
    }

    /**
     * Remove labo
     *
     * @param \AppBundle\Entity\Labo $labo
     */
    public function removeLabo(\AppBundle\Entity\Labo $labo)
    {
        $this->labo->removeElement($labo);
    }

    /**
     * Get labo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLabo()
    {
        return $this->labo;
    }

    /**
     * Add formation
     *
     * @param \AppBundle\Entity\Formation $formation
     *
     * @return Localisation
     */
    public function addFormation(\AppBundle\Entity\Formation $formation)
    {
        $this->formation[] = $formation;

        return $this;
    }

    /**
     * Remove formation
     *
     * @param \AppBundle\Entity\Formation $formation
     */
    public function removeFormation(\AppBundle\Entity\Formation $formation)
    {
        $this->formation->removeElement($formation);
    }

    /**
     * Get formation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Add etablissement
     *
     * @param \AppBundle\Entity\Etablissement $etablissement
     *
     * @return Localisation
     */
    public function addEtablissement(\AppBundle\Entity\Etablissement $etablissement)
    {
        $this->etablissement[] = $etablissement;

        return $this;
    }

    /**
     * Remove etablissement
     *
     * @param \AppBundle\Entity\Etablissement $etablissement
     */
    public function removeEtablissement(\AppBundle\Entity\Etablissement $etablissement)
    {
        $this->etablissement->removeElement($etablissement);
    }

    /**
     * Get etablissement
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Add ed
     *
     * @param \AppBundle\Entity\Ed $ed
     *
     * @return Localisation
     */
    public function addEd(\AppBundle\Entity\Ed $ed)
    {
        $this->ed[] = $ed;

        return $this;
    }

    /**
     * Remove ed
     *
     * @param \AppBundle\Entity\Ed $ed
     */
    public function removeEd(\AppBundle\Entity\Ed $ed)
    {
        $this->ed->removeElement($ed);
    }

    /**
     * Get ed
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEd()
    {
        return $this->ed;
    }
}
