<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Labo
 *
 * @ORM\Table(name="laboratoire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LaboRepository")
 */
class Labo
{

    /**
     * @var integer
     *
     * @ORM\Column(name="laboratoire_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(
     *     message = "Un nom doit être renseigné pour permettre la sauvegarde"
     * )
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
     *
     * @Assert\Length(
     *      max = 2500,
     *      maxMessage = "La description ne peut dépasser {{ limit }} caractères"
     * )
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

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_thesaurus", referencedColumnName="thesaurus_id")
     * })
     */
    private $type_thesaurus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="laboratoire_has_theme",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="thesaurus_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $theme;

    /**
     * @var integer
     *
     * @ORM\Column(name="effectif", type="integer", nullable=true)
     */
    private $effectif;


    /**
     * @var integer
     *
     * @ORM\Column(name="effectif_hesam", type="integer", nullable=true)
     */
    private $effectifHesam;

    /**
     * @var string
     *
     * @ORM\Column(name="objet_id", type="string", length=255, nullable=true)
     */
    private $objetId;

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
     * @ORM\Column(name="uai", type="string", length=25, nullable=true)
     */
    private $uai;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee_collecte", type="integer", nullable=true)
     */
    private $anneeCollecte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $date_creation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="datetime", nullable=false)
     */
    private $last_update;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Membre", inversedBy="labo", cascade= {"persist"})
     * @ORM\JoinTable(name="participant_has_laboratoire",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="participant_id", referencedColumnName="participant_id")
     *   }
     * )
     */
    private $membre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", inversedBy="labo", cascade= {"persist"})
     * @ORM\JoinTable(name="laboratoire_has_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="tag_id")
     *   }
     * )
     */
    private $tag;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ufr", mappedBy="labo")
     */
    private $ufr;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Localisation", mappedBy="labo")
     */
    private $localisation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Formation", inversedBy="labo")
     * @ORM\JoinTable(name="laboratoire_has_formation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Discipline", mappedBy="labo")
     *
     *
     */
    private $discipline;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Discipline")
     * @ORM\JoinTable(name="laboratoire_has_cnu",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="discipline_id", referencedColumnName="discipline_id")
     *   }
     * )
     *
     * @Assert\Count(
     *      max = 5,
     *      minMessage = "Vous devez choisir au moins une discipline CNU",
     *      maxMessage = "Vous ne pouvez choisir plus de 5 disciplines"
     * )
     */
    private $cnu;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Discipline")
     * @ORM\JoinTable(name="laboratoire_has_sise",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="discipline_id", referencedColumnName="discipline_id")
     *   }
     * )
     *
     * @Assert\Count(
     *      max = 5,
     *      minMessage = "Vous devez choisir au moins une discipline SISE",
     *      maxMessage = "Vous ne pouvez choisir plus de 5 disciplines"
     * )
     *
     */
    private $sise;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Discipline")
     * @ORM\JoinTable(name="laboratoire_has_hceres",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="discipline_id", referencedColumnName="discipline_id")
     *   }
     * )
     *
     * @Assert\Count(
     *      max = 5,
     *      minMessage = "Vous devez choisir au moins une discipline HCERES",
     *      maxMessage = "Vous ne pouvez choisir plus de 5 disciplines"
     * )
     *
     */
    private $hceres;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Etablissement", mappedBy="labo")
     */
    private $etablissement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Equipement", inversedBy="labo", cascade= {"persist"})
     * @ORM\JoinTable(name="laboratoire_has_equipement",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ed", inversedBy="labo")
     * @ORM\JoinTable(name="ecole_doctorale_has_laboratoire",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ecole_doctorale_id", referencedColumnName="ecole_doctorale_id")
     *   }
     * )
     */
    private $ed;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Axe", inversedBy="labo", cascade= {"persist"})
     * @ORM\JoinTable(name="laboratoire_has_axe",
     *   joinColumns={
     *     @ORM\JoinColumn(name="laboratoire_id", referencedColumnName="laboratoire_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="axe_id", referencedColumnName="axe_id")
     *   }
     * )
     */
    private $axes;

    /**
    *
    * @ORM\Column(name="check1", type="boolean")
    */
    private $check_general = false;

    /**
     *
     * @ORM\Column(name="check2", type="boolean")
     */
    private $check_contact = false;

    /**
     *
     * @ORM\Column(name="check3", type="boolean")
     */
    private $check_etab = false;

    /**
     *
     * @ORM\Column(name="check4", type="boolean")
     */
    private $check_description = false;

    /**
     *
     * @ORM\Column(name="check5", type="boolean")
     */
    private $check_effectifs = false ;

    /**
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide = false;

    /**
     * @var string
     *
     * @ORM\Column(name="code_interne", type="string", length=100, nullable=true)
     */
    private $code_interne;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->membre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ufr = new \Doctrine\Common\Collections\ArrayCollection();
        $this->localisation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->discipline = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etablissement = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipement = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ed = new \Doctrine\Common\Collections\ArrayCollection();
        $this->axes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
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
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param \DateTime $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param \DateTime $last_update
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;
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

    /**
     * Set id
     *
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Clean id
     *
     * @return integer
     */
    public function cleanId()
    {
        $this->id = null;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
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
     * Add localisation
     *
     * @param \AppBundle\Entity\Localisation $localisation
     *
     * @return Localisation
     */
    public function addLocalisation(\AppBundle\Entity\Localisation $localisation)
    {
        if ($this->localisation->contains($localisation)) {
            return;
        }

        $this->localisation[] = $localisation;
        $localisation->addLabo($this);

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
        $localisation->removeLabo($this);
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
     * Add discipline
     *
     * @param \AppBundle\Entity\Discipline $discipline
     *
     * @return Labo
     */
    public function addDiscipline(\AppBundle\Entity\Discipline $discipline)
    {

        if ($this->discipline->contains($discipline)) {
            return;
        }

        $this->discipline[] = $discipline;
        $discipline->addLabo($this);

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
        $discipline->removeLabo($this);
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
     * Get Hesamette
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHesamette()
    {
        $mesHesamette = Array();
        foreach($this->discipline as $disc) {
            if($disc->getHesamette()) {
                if(!in_array($disc->getHesamette()->getNom(), $mesHesamette, true)){
                    array_push($mesHesamette, $disc->getHesamette()->getNom());
                }
            }

        }
        return $mesHesamette;
    }



    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Add etablissement
     *
     * @param \AppBundle\Entity\Etablissement $etablissement
     *
     * @return Labo
     */
    public function addEtablissement(Etablissement $etablissement)
    {
        if ($this->etablissement->contains($etablissement)) {
            return;
        }

        $this->etablissement[] = $etablissement;
        $etablissement->addLabo($this);
    }

    /**
     * Remove etablissement
     *
     * @param \AppBundle\Entity\Etablissement etablissement
     */
    public function removeEtablissement(Etablissement $etablissement)
    {
        $this->etablissement->removeElement($etablissement);
        $etablissement->removeLabo($this);
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

    /**
     * @return Thesaurus
     */
    public function getTypeThesaurus()
    {
        return $this->type_thesaurus;
    }

    /**
     * @param Thesaurus $type_thesaurus
     */
    public function setTypeThesaurus($type_thesaurus)
    {
        $this->type_thesaurus = $type_thesaurus;
    }

    /**
     * @return mixed
     */
    public function getAxes()
    {
        return $this->axes;
    }

    /**
     * @param mixed $axes
     */
    public function setAxes($axes)
    {
        $this->axes = $axes;
    }

    /**
     * @return int
     */
    public function getEffectifHesam()
    {
        return $this->effectifHesam;
    }

    /**
     * @param int $effectifHesam
     */
    public function setEffectifHesam($effectifHesam)
    {
        $this->effectifHesam = $effectifHesam;
    }

    /**
     * @return int
     */
    public function getAnneeCollecte()
    {
        return $this->anneeCollecte;
    }

    /**
     * @param int $anneeCollecte
     */
    public function setAnneeCollecte($anneeCollecte)
    {
        $this->anneeCollecte = $anneeCollecte;
    }

    /**
     * @return string
     */
    public function getObjetId()
    {
        return $this->objetId;
    }

    /**
     * @param string $objetId
     */
    public function setObjetId($objetId)
    {
        $this->objetId = $objetId;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCnu()
    {
        return $this->cnu;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $cnu
     */
    public function setCnu($cnu)
    {
        $this->cnu = $cnu;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSise()
    {
        return $this->sise;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $sise
     */
    public function setSise($sise)
    {
        $this->sise = $sise;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHceres()
    {
        return $this->hceres;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $hceres
     */
    public function setHceres($hceres)
    {
        $this->hceres = $hceres;
    }

    /**
     * @return mixed
     */
    public function getCheckGeneral()
    {
        return $this->check_general;
    }

    /**
     * @param mixed $check_general
     */
    public function setCheckGeneral($check_general)
    {
        $this->check_general = $check_general;
    }

    /**
     * @return mixed
     */
    public function getCheckContact()
    {
        return $this->check_contact;
    }

    /**
     * @param mixed $check_contact
     */
    public function setCheckContact($check_contact)
    {
        $this->check_contact = $check_contact;
    }

    /**
     * @return mixed
     */
    public function getCheckEtab()
    {
        return $this->check_etab;
    }

    /**
     * @param mixed $check_etab
     */
    public function setCheckEtab($check_etab)
    {
        $this->check_etab = $check_etab;
    }

    /**
     * @return mixed
     */
    public function getCheckDescription()
    {
        return $this->check_description;
    }

    /**
     * @param mixed $check_description
     */
    public function setCheckDescription($check_description)
    {
        $this->check_description = $check_description;
    }

    /**
     * @return mixed
     */
    public function getCheckEffectifs()
    {
        return $this->check_effectifs;
    }

    /**
     * @param mixed $check_effectifs
     */
    public function setCheckEffectifs($check_effectifs)
    {
        $this->check_effectifs = $check_effectifs;
    }

    /**
     * @return mixed
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * @param mixed $valide
     */
    public function setValide($valide)
    {
        $this->valide = $valide;
    }

    /**
     * @return code_interne
     */
    public function getCodeInterne()
    {
        return $this->code_interne;
    }

    /**
      * Set code_interne
      *
      * @param string $code_interne
      *
      * @return Labo
      */

    public function setCodeInterne($code_interne)
    {
        $this->code_interne = $code_interne;
    }

    /**
     * Get localisation mapping
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGeo()
    {
        foreach($this->localisation as $geo) {
            if ($geo->getLat())
                return $geo->getLat().",".$geo->getLong();
        }
    }

    public function __toString()
    {
        return (string) $this->getNom();
    }


}
