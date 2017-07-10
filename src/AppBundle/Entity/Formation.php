<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Formation
 *
 * @ORM\Table(name="formation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationRepository")
 */
class Formation
{

    /**
     * @var integer
     *
     * @ORM\Column(name="formation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $formationId;

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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee", type="integer", nullable=true)
     */
    private $annee;

    /**
     * @var string
     *
     * @ORM\Column(name="objet_id", type="string", length=255, nullable=true)
     */
    private $objetId;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee_collecte", type="integer", nullable=true)
     */
    private $anneeCollecte;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255, nullable=true)
     */
    private $niveau;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="niveau_thesaurus", referencedColumnName="thesaurus_id")
     * })
     */
    private $niveau_thesaurus;

    /**
     * @var string
     *
     * @ORM\Column(name="lmd", type="string", length=255, nullable=true)
     */
    private $lmd;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lmd_thesaurus", referencedColumnName="thesaurus_id")
     * })
     */
    private $lmd_thesaurus;

    /**
     * @var string
     *
     * @ORM\Column(name="typeDiplome", type="string", length=255, nullable=true)
     */
    private $typediplome;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typediplome_thesaurus", referencedColumnName="thesaurus_id")
     * })
     */
    private $typediplome_thesaurus;

    /**
     * @var integer
     *
     * @ORM\Column(name="effectif", type="integer", nullable=true)
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 1000000,
     *      minMessage = "Il ne peut y avoir d'effectif négatif",
     *      maxMessage = "Le nombre d'effectifs entré est (bien) trop élevé"
     * )
     *
     */
    private $effectif;

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
     * @ORM\Column(name="responsable", type="string", length=500, nullable=true)
     */
    private $responsable;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Localisation", mappedBy="formation")
     */
    private $localisation;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Membre", inversedBy="formation", cascade= {"persist"})
     * @ORM\JoinTable(name="participant_has_formation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", inversedBy="formation", cascade= {"persist"})
     * @ORM\JoinTable(name="formation_has_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Labo", mappedBy="formation")
     */
    private $labo;

    /**
     * @var string
     *
     * @ORM\Column(name="ects", type="integer", length=255, nullable=true)
     */
    private $ects;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="formation_has_modalite",
     *   joinColumns={
     *     @ORM\JoinColumn(name="formation", referencedColumnName="formation_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="modalite_thesaurus", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $modalite_thesaurus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ufr", inversedBy="formation")
     * @ORM\JoinTable(name="formation_has_ufr",
     *   joinColumns={
     *     @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Etablissement", mappedBy="formation", cascade={"persist"})
     */
    private $etablissement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Discipline")
     * @ORM\JoinTable(name="formation_has_cnu",
     *   joinColumns={
     *     @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
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
     * @ORM\JoinTable(name="formation_has_sise",
     *   joinColumns={
     *     @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
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
     * @ORM\JoinTable(name="formation_has_hceres",
     *   joinColumns={
     *     @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Metier3")
     * @ORM\JoinTable(name="formation_has_metier3",
     *   joinColumns={
     *     @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="metier_id", referencedColumnName="id")
     *   }
     * )
     *
     */
    private $metier;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Discipline", mappedBy="formation")
     */
    private $discipline;

    /**
     *
     * @ORM\Column(name="check1", type="boolean")
     */
    private $check_general = false;

    /**
     *
     * @ORM\Column(name="check2", type="boolean")
     */
    private $check_effectif = false;

    /**
     *
     * @ORM\Column(name="check3", type="boolean")
     */
    private $check_index = false;

    /**
     *
     * @ORM\Column(name="check4", type="boolean")
     */
    private $check_cursus = false;

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
        $this->localisation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->membre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
        $this->labo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ufr = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etablissement = new \Doctrine\Common\Collections\ArrayCollection();
        $this->discipline = new \Doctrine\Common\Collections\ArrayCollection();
        $this->metier = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Formation
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
     * Set description
     *
     * @param string $description
     *
     * @return Formation
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
     * Set url
     *
     * @param string $url
     *
     * @return Formation
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
     * Set annee
     *
     * @param integer $annee
     *
     * @return Formation
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set niveau
     *
     * @param string $niveau
     *
     * @return Formation
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
     * Set typediplome
     *
     * @param string $typediplome
     *
     * @return Formation
     */
    public function setTypediplome($typediplome)
    {
        $this->typediplome = $typediplome;

        return $this;
    }

    /**
     * Get typediplome
     *
     * @return string
     */
    public function getTypediplome()
    {
        return $this->typediplome;
    }

    /**
     * Set effectif
     *
     * @param integer $effectif
     *
     * @return Formation
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
     * Set lien2
     *
     * @param string $lien2
     *
     * @return Formation
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
     * @return Formation
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
     * Set responsable
     *
     * @param string $responsable
     *
     * @return Formation
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
     *
     */
    public function getResponsable()
    {
        return $this->responsable;
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
     * Get formationId
     *
     * @return integer
     */
    public function getFormationId()
    {
        return $this->formationId;
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
        $localisation->addFormation($this);

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
        $localisation->removeFormation($this);
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
     * @return Formation
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
     * Add labo
     *
     * @param \AppBundle\Entity\Labo $labo
     *
     * @return Formation
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
     * Add ufr
     *
     * @param \AppBundle\Entity\Ufr $ufr
     *
     * @return Formation
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
     * @return Formation
     */
    public function addEtablissement(Etablissement $etablissement)
    {
        if ($this->etablissement->contains($etablissement)) {
            return;
        }

        $this->etablissement[] = $etablissement;
        $etablissement->addFormation($this);
    }

    /**
     * Remove etablissement
     *
     * @param \AppBundle\Entity\Etablissement etablissement
     */
    public function removeEtablissement(Etablissement $etablissement)
    {
        $this->etablissement->removeElement($etablissement);
        $etablissement->removeFormation($this);
    }

    /**
     * Add discipline
     *
     * @param \AppBundle\Entity\Discipline $discipline
     *
     * @return Formation
     */
    public function addDiscipline(\AppBundle\Entity\Discipline $discipline)
    {

        if ($this->discipline->contains($discipline)) {
            return;
        }

        $this->discipline[] = $discipline;
        $discipline->addFormation($this);

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
        $discipline->removeFormation($this);
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
     * @return Thesaurus
     */
    public function getLmdThesaurus()
    {
        return $this->lmd_thesaurus;
    }

    /**
     * @param Thesaurus $lmd_thesaurus
     */
    public function setLmdThesaurus($lmd_thesaurus)
    {
        $this->lmd_thesaurus = $lmd_thesaurus;
    }


    /**
     * @return string
     */
    public function getLmd()
    {
        return $this->lmd;
    }

    /**
     * @param string $lmd
     */
    public function setLmd($lmd)
    {
        $this->lmd = $lmd;
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
     * @return string
     */
    public function getEcts()
    {
        return $this->ects;
    }

    /**
     * @param string $ects
     */
    public function setEcts($ects)
    {
        $this->ects = $ects;
    }

    /**
     * @return string
     */
    public function getModalite()
    {
        return $this->modalite;
    }

    /**
     * @param string $modalite
     */
    public function setModalite($modalite)
    {
        $this->modalite = $modalite;
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
    public function getCheckEffectif()
    {
        return $this->check_effectif;
    }

    /**
     * @param mixed $check_effectif
     */
    public function setCheckEffectif($check_effectif)
    {
        $this->check_effectif = $check_effectif;
    }

    /**
     * @return mixed
     */
    public function getCheckIndex()
    {
        return $this->check_index;
    }

    /**
     * @param mixed $check_index
     */
    public function setCheckIndex($check_index)
    {
        $this->check_index = $check_index;
    }

    /**
     * @return mixed
     */
    public function getCheckCursus()
    {
        return $this->check_cursus;
    }

    /**
     * @param mixed $check_cursus
     */
    public function setCheckCursus($check_cursus)
    {
        $this->check_cursus = $check_cursus;
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
     * @return Thesaurus
     */
    public function getTypediplomeThesaurus()
    {
        return $this->typediplome_thesaurus;
    }

    /**
     * @param Thesaurus $typediplome_thesaurus
     */
    public function setTypediplomeThesaurus($typediplome_thesaurus)
    {
        $this->typediplome_thesaurus = $typediplome_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getModaliteThesaurus()
    {
        return $this->modalite_thesaurus;
    }

    /**
     * @param Thesaurus $modalite_thesaurus
     */
    public function setModaliteThesaurus($modalite_thesaurus)
    {
        $this->modalite_thesaurus = $modalite_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getNiveauThesaurus()
    {
        return $this->niveau_thesaurus;
    }

    /**
     * @param Thesaurus $niveau_thesaurus
     */
    public function setNiveauThesaurus($niveau_thesaurus)
    {
        $this->niveau_thesaurus = $niveau_thesaurus;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMetier()
    {
        return $this->metier;
    }

    /**
     * Add metier
     *
     * @param \AppBundle\Entity\Metier3 $metier
     *
     * @return Formation
     */
    public function addMetier(\AppBundle\Entity\Metier3 $metier)
    {
        $this->metier[] = $metier;

        return $this;
    }

    /**
     * Remove metier
     *
     * @param \AppBundle\Entity\Metier3 $metier
     */
    public function removeMetier(\AppBundle\Entity\Metier3 $metier)
    {
        $this->metier->removeElement($metier);
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $metier
     */
    public function setMetier($metier)
    {
        $this->metier = $metier;
    }

    public function __toString()
    {
        return (string) $this->getNom();
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
     * @return Formation
     */
    public function setCodeInterne($code_interne)
    {
        $this->code_interne = $code_interne;
    }
}
