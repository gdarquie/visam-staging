<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Etablissement
 *
 * @ORM\Table(name="etablissement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtablissementRepository")
 */
class Etablissement
{
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
     * @ORM\Column(name="description", type="text", length=16777215, nullable=true)
     *
     * @Assert\Length(
     *      max = 2500,
     *      maxMessage = "La description ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=45, nullable=true)
     */
    private $code;

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
     * @ORM\Column(name="lien", type="string", length=255, nullable=true)
     */
    private $lien;

    /**
     * @var string
     *
     * @ORM\Column(name="ministere", type="string", length=255, nullable=true)
     */
    private $ministere;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinTable(name="etablissement_has_ministere",
     *   joinColumns={
     *     @ORM\JoinColumn(name="etablissement_id", referencedColumnName="etablissement_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="thesaurus_id", referencedColumnName="thesaurus_id")
     *   }
     * )
     */
    private $ministere_thesaurus;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true)
     */
    private $statut;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="statut_thesaurus_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $statut_thesaurus;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @var string
     *
     * @ORM\Column(name="FC", type="string", length=255, nullable=true)
     */
    private $fc;

    /**
     * @var string
     *
     * @ORM\Column(name="FC_lien", type="string", length=255, nullable=true)
     */
    private $fcLien;

    /**
     * @var integer
     *
     * @ORM\Column(name="etudiants", type="integer", nullable=true)
     */
    private $etudiants;

    /**
     * @var integer
     *
     * @ORM\Column(name="chercheurs", type="integer", nullable=true)
     */
    private $chercheurs;

    /**
     * @var integer
     *
     * @ORM\Column(name="intervenants", type="integer", nullable=true)
     */
    private $intervenants;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee_collecte", type="integer", nullable=true)
     */
    private $anneeCollecte;

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
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;

    /** @var  \AppBundle\Entity\Thesaurus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thesaurus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="position_thesaurus_id", referencedColumnName="thesaurus_id")
     * })
     */
    private $position_thesaurus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entree", type="datetime", nullable=true)
     */
    private $entree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sortie", type="datetime", nullable=true)
     */
    private $sortie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $date_creation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="datetime" , nullable=true)
     */
    private $last_update;

    /**
     * @var integer
     *
     * @ORM\Column(name="etablissement_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $etablissementId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Localisation", mappedBy="etablissement")
     */
    private $localisation;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Valorisation", inversedBy="etablissement")
     * @ORM\JoinTable(name="etablissement_has_valorisation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="etablissement_id", referencedColumnName="etablissement_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="valorisation_id", referencedColumnName="valorisation_id")
     *   }
     * )
     */
    private $valorisation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Labo", inversedBy="etablissement")
     * @ORM\JoinTable(name="etablissement_has_labo",
     *   joinColumns={
     *     @ORM\JoinColumn(name="etablissement_id", referencedColumnName="etablissement_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Formation", inversedBy="etablissement", cascade={"persist"})
     * @ORM\JoinTable(name="etablissement_has_formation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="etablissement_id", referencedColumnName="etablissement_id")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ed", inversedBy="etablissement")
     * @ORM\JoinTable(name="etablissement_has_ED",
     *   joinColumns={
     *     @ORM\JoinColumn(name="etablissement_id", referencedColumnName="etablissement_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ED_id", referencedColumnName="ED_id")
     *   }
     * )
     */
    private $ed;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Collecte", mappedBy="etablissement")
     */
    private $collecte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date_creation = new \DateTime();
        $this->last_update = new \DateTime();
        $this->localisation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->valorisation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->labo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ed = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Etablissement
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
     * @return Etablissement
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
     * @param string $code
     *
     * @return Etablissement
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
     * Set sigle
     *
     * @param string $sigle
     *
     * @return Etablissement
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
     * Set lien
     *
     * @param string $lien
     *
     * @return Etablissement
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
     * Set ministere
     *
     * @param string $ministere
     *
     * @return Etablissement
     */
    public function setMinistere($ministere)
    {
        $this->ministere = $ministere;

        return $this;
    }

    /**
     * Get ministere
     *
     * @return string
     */
    public function getMinistere()
    {
        return $this->ministere;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Etablissement
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStatutThesaurus()
    {
        return $this->statut_thesaurus;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $statut_thesaurus
     */
    public function setStatutThesaurus($statut_thesaurus)
    {
        $this->statut_thesaurus = $statut_thesaurus;
    }


    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Etablissement
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMinistereThesaurus()
    {
        return $this->ministere_thesaurus;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $ministere_thesaurus
     */
    public function setMinistereThesaurus($ministere_thesaurus)
    {
        $this->ministere_thesaurus = $ministere_thesaurus;
    }

    /**
     * @return Thesaurus
     */
    public function getPositionThesaurus()
    {
        return $this->position_thesaurus;
    }

    /**
     * @param Thesaurus $position_thesaurus
     */
    public function setPositionThesaurus($position_thesaurus)
    {
        $this->position_thesaurus = $position_thesaurus;
    }

    /**
     * Set fc
     *
     * @param string $fc
     *
     * @return Etablissement
     */
    public function setFc($fc)
    {
        $this->fc = $fc;

        return $this;
    }

    /**
     * Get fc
     *
     * @return string
     */
    public function getFc()
    {
        return $this->fc;
    }

    /**
     * Set fcLien
     *
     * @param string $fcLien
     *
     * @return Etablissement
     */
    public function setFcLien($fcLien)
    {
        $this->fcLien = $fcLien;

        return $this;
    }

    /**
     * Get fcLien
     *
     * @return string
     */
    public function getFcLien()
    {
        return $this->fcLien;
    }

    /**
     * Set etudiants
     *
     * @param integer $etudiants
     *
     * @return Etablissement
     */
    public function setEtudiants($etudiants)
    {
        $this->etudiants = $etudiants;

        return $this;
    }

    /**
     * Get etudiants
     *
     * @return integer
     */
    public function getEtudiants()
    {
        return $this->etudiants;
    }

    /**
     * Set chercheurs
     *
     * @param integer $chercheurs
     *
     * @return Etablissement
     */
    public function setChercheurs($chercheurs)
    {
        $this->chercheurs = $chercheurs;

        return $this;
    }

    /**
     * Get chercheurs
     *
     * @return integer
     */
    public function getChercheurs()
    {
        return $this->chercheurs;
    }

    /**
     * Set lien2
     *
     * @param string $lien2
     *
     * @return Etablissement
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
     * @return Etablissement
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
     * Get etablissementId
     *
     * @return integer
     */
    public function getEtablissementId()
    {
        return $this->etablissementId;
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
        $localisation->addEtablissement($this);

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
        $localisation->removeLocalisation($this);
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
     * Add valorisation
     *
     * @param \AppBundle\Entity\Valorisation $valorisation
     *
     * @return Etablissement
     */
    public function addValorisation(\AppBundle\Entity\Valorisation $valorisation)
    {
        $this->valorisation[] = $valorisation;

        return $this;
    }

    /**
     * Remove valorisation
     *
     * @param \AppBundle\Entity\Valorisation $valorisation
     */
    public function removeValorisation(\AppBundle\Entity\Valorisation $valorisation)
    {
        $this->valorisation->removeElement($valorisation);
    }

    /**
     * Get valorisation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getValorisation()
    {
        return $this->valorisation;
    }

    /**
     * Add labo
     *
     * @param \AppBundle\Entity\Labo $labo
     *
     * @return Etablissement
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
     * @return Etablissement
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
     * Add ed
     *
     * @param \AppBundle\Entity\Ed $ed
     *
     * @return Etablissement
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollecte()
    {
        return $this->collecte;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $collecte
     */
    public function setCollecte($collecte)
    {
        $this->collecte = $collecte;
    }


    /**
     * @return int
     */
    public function getIntervenants()
    {
        return $this->intervenants;
    }

    /**
     * @param int $intervenants
     */
    public function setIntervenants($intervenants)
    {
        $this->intervenants = $intervenants;
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

    public function __toString()
    {
        return (string) $this->getNom();
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return \DateTime
     */
    public function getEntree()
    {
        return $this->entree;
    }

    /**
     * @param \DateTime $entree
     */
    public function setEntree($entree)
    {
        $this->entree = $entree;
    }

    /**
     * @return \DateTime
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * @param \DateTime $sortie
     */
    public function setSortie($sortie)
    {
        $this->sortie = $sortie;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
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
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

}
