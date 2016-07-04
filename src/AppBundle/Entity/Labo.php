<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Labo
 *
 * @ORM\Table(name="labo")
 * @ORM\Entity
 */
class Labo
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
     * @ORM\Column(name="etab_ext", type="text", length=65535, nullable=true)
     */
    private $etabExt;

    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=255, nullable=true)
     */
    private $lien;

    /**
     * @var string
     *
     * @ORM\Column(name="mailContact", type="string", length=255, nullable=true)
     */
    private $mailcontact;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=500, nullable=true)
     */
    private $responsable;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=16777215, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="integer", nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=5, nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="effectif", type="integer", nullable=true)
     */
    private $effectif;

    /**
     * @var string
     *
     * @ORM\Column(name="sigle", type="string", length=45, nullable=true)
     */
    private $sigle;

    /**
     * @var string
     *
     * @ORM\Column(name="lien2", type="string", length=255, nullable=true)
     */
    private $lien2;

    /**
     * @var string
     *
     * @ORM\Column(name="lien3", type="string", length=255, nullable=true)
     */
    private $lien3;

    /**
     * @var string
     *
     * @ORM\Column(name="uai", type="string", length=25, nullable=false)
     */
    private $uai;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="labo_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $laboId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Localisation", mappedBy="labo")
     */
    private $localisation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Membre", mappedBy="labo")
     */
    private $membre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ufr", mappedBy="labo")
     */
    private $ufr;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Formation", inversedBy="labo")
     * @ORM\JoinTable(name="labo_has_formation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="labo_id", referencedColumnName="labo_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Equipement", inversedBy="labo")
     * @ORM\JoinTable(name="labo_has_equipement",
     *   joinColumns={
     *     @ORM\JoinColumn(name="labo_id", referencedColumnName="labo_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="equipement_id", referencedColumnName="equipement_id")
     *   }
     * )
     */
    private $equipement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Discipline", mappedBy="labo")
     */
    private $discipline;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Etablissement", mappedBy="labo")
     */
    private $etablissement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ed", inversedBy="labo")
     * @ORM\JoinTable(name="ed_has_labo",
     *   joinColumns={
     *     @ORM\JoinColumn(name="labo_id", referencedColumnName="labo_id")
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
        $this->localisation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->membre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ufr = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipement = new \Doctrine\Common\Collections\ArrayCollection();
        $this->discipline = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etablissement = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ed = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Labo
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
     * Set etabExt
     *
     * @param string $etabExt
     *
     * @return Labo
     */
    public function setEtabExt($etabExt)
    {
        $this->etabExt = $etabExt;

        return $this;
    }

    /**
     * Get etabExt
     *
     * @return string
     */
    public function getEtabExt()
    {
        return $this->etabExt;
    }

    /**
     * Set lien
     *
     * @param string $lien
     *
     * @return Labo
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien
     *
     * @return string
     */
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set mailcontact
     *
     * @param string $mailcontact
     *
     * @return Labo
     */
    public function setMailcontact($mailcontact)
    {
        $this->mailcontact = $mailcontact;

        return $this;
    }

    /**
     * Get mailcontact
     *
     * @return string
     */
    public function getMailcontact()
    {
        return $this->mailcontact;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     *
     * @return Labo
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Labo
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
     * Set code
     *
     * @param integer $code
     *
     * @return Labo
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Labo
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set effectif
     *
     * @param integer $effectif
     *
     * @return Labo
     */
    public function setEffectif($effectif)
    {
        $this->effectif = $effectif;

        return $this;
    }

    /**
     * Get effectif
     *
     * @return integer
     */
    public function getEffectif()
    {
        return $this->effectif;
    }

    /**
     * Set sigle
     *
     * @param string $sigle
     *
     * @return Labo
     */
    public function setSigle($sigle)
    {
        $this->sigle = $sigle;

        return $this;
    }

    /**
     * Get sigle
     *
     * @return string
     */
    public function getSigle()
    {
        return $this->sigle;
    }

    /**
     * Set lien2
     *
     * @param string $lien2
     *
     * @return Labo
     */
    public function setLien2($lien2)
    {
        $this->lien2 = $lien2;

        return $this;
    }

    /**
     * Get lien2
     *
     * @return string
     */
    public function getLien2()
    {
        return $this->lien2;
    }

    /**
     * Set lien3
     *
     * @param string $lien3
     *
     * @return Labo
     */
    public function setLien3($lien3)
    {
        $this->lien3 = $lien3;

        return $this;
    }

    /**
     * Get lien3
     *
     * @return string
     */
    public function getLien3()
    {
        return $this->lien3;
    }

    /**
     * Set uai
     *
     * @param string $uai
     *
     * @return Labo
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Labo
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
     * Get laboId
     *
     * @return integer
     */
    public function getLaboId()
    {
        return $this->laboId;
    }

    /**
     * Add localisation
     *
     * @param \AppBundle\Entity\Localisation $localisation
     *
     * @return Labo
     */
    public function addLocalisation(\AppBundle\Entity\Localisation $localisation)
    {
        $this->localisation[] = $localisation;

        return $this;
    }

    /**
     * Remove localisation
     *
     * @param \AppBundle\Entity\Localisation $localisation
     */
    public function removeLocalisation(\AppBundle\Entity\Localisation $localisation)
    {
        $this->localisation->removeElement($localisation);
    }

    /**
     * Get localisation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Add membre
     *
     * @param \AppBundle\Entity\Membre $membre
     *
     * @return Labo
     */
    public function addMembre(\AppBundle\Entity\Membre $membre)
    {
        $this->membre[] = $membre;

        return $this;
    }

    /**
     * Remove membre
     *
     * @param \AppBundle\Entity\Membre $membre
     */
    public function removeMembre(\AppBundle\Entity\Membre $membre)
    {
        $this->membre->removeElement($membre);
    }

    /**
     * Get membre
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * Add ufr
     *
     * @param \AppBundle\Entity\Ufr $ufr
     *
     * @return Labo
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
     * Add formation
     *
     * @param \AppBundle\Entity\Formation $formation
     *
     * @return Labo
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
     * Add equipement
     *
     * @param \AppBundle\Entity\Equipement $equipement
     *
     * @return Labo
     */
    public function addEquipement(\AppBundle\Entity\Equipement $equipement)
    {
        $this->equipement[] = $equipement;

        return $this;
    }

    /**
     * Remove equipement
     *
     * @param \AppBundle\Entity\Equipement $equipement
     */
    public function removeEquipement(\AppBundle\Entity\Equipement $equipement)
    {
        $this->equipement->removeElement($equipement);
    }

    /**
     * Get equipement
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipement()
    {
        return $this->equipement;
    }

    /**
     * Add discipline
     *
     * @param \AppBundle\Entity\Discipline $discipline
     *
     * @return Labo
     */
    public function addDiscipline(\AppBundle\Entity\Discipline $discipline)
    {
        $this->discipline[] = $discipline;

        return $this;
    }

    /**
     * Remove discipline
     *
     * @param \AppBundle\Entity\Discipline $discipline
     */
    public function removeDiscipline(\AppBundle\Entity\Discipline $discipline)
    {
        $this->discipline->removeElement($discipline);
    }

    /**
     * Get discipline
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * Add etablissement
     *
     * @param \AppBundle\Entity\Etablissement $etablissement
     *
     * @return Labo
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
     * @return Labo
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
