<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table(name="formation")
 * @ORM\Entity
 */
class Formation
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
     * @ORM\Column(name="niveau", type="string", length=255, nullable=true)
     */
    private $niveau;

    /**
     * @var string
     *
     * @ORM\Column(name="typeDiplome", type="string", length=255, nullable=true)
     */
    private $typediplome;

    /**
     * @var integer
     *
     * @ORM\Column(name="effectif", type="integer", nullable=true)
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
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="formation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $formationId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Localisation", mappedBy="formation")
     */
    private $localisation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Membre", mappedBy="formation")
     */
    private $membre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", mappedBy="formation")
     */
    private $tag;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Labo", mappedBy="formation")
     */
    private $labo;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Etablissement", mappedBy="formation")
     */
    private $etablissement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Metier", inversedBy="formation")
     * @ORM\JoinTable(name="formation_has_metier",
     *   joinColumns={
     *     @ORM\JoinColumn(name="formation_id", referencedColumnName="formation_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="metier_id", referencedColumnName="metier_id")
     *   }
     * )
     */
    private $metier;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Discipline", mappedBy="formation")
     */
    private $discipline;

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
        $this->metier = new \Doctrine\Common\Collections\ArrayCollection();
        $this->discipline = new \Doctrine\Common\Collections\ArrayCollection();
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
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Formation
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
     * @return Formation
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
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Formation
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
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
     * Add etablissement
     *
     * @param \AppBundle\Entity\Etablissement $etablissement
     *
     * @return Formation
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
     * Add metier
     *
     * @param \AppBundle\Entity\Metier $metier
     *
     * @return Formation
     */
    public function addMetier(\AppBundle\Entity\Metier $metier)
    {
        $this->metier[] = $metier;

        return $this;
    }

    /**
     * Remove metier
     *
     * @param \AppBundle\Entity\Metier $metier
     */
    public function removeMetier(\AppBundle\Entity\Metier $metier)
    {
        $this->metier->removeElement($metier);
    }

    /**
     * Get metier
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMetier()
    {
        return $this->metier;
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
}
