<?php
namespace EditeurBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Liuggio\ExcelBundle\Factory;
use AppBundle\Entity\Etablissement;
use AppBundle\Entity\Ed;



class ExportService
{

    protected $em;
    protected $log;
    protected $factory;
    protected $type;
    protected $etablissement;
    const TYPE_FORMATION = 1;
    const TYPE_LABO = 2;

    public function __construct(EntityManager $em, Logs $log, Factory $factory)
    {
        $this->em = $em;
        $this->log = $log;
        $this->factory = $factory;
    }

    public function getHeaderFormation()
    {
        $header = [
            "Année",
            "Code UAI",
            "Nom établissement",
            "Nom du centre",
            "Latitude",
            "Longitude",
            "Adresse",
            "Complément d'adresse",
            "Ville de l'UF",
            "Code postal de l'UF",
            "Cedex de l'UF",
            "Région",
            "Pays",
            "Type diplôme",
            "Niv. Bac +",
            "Parcours LMD",
            "Modalités de formation",
            "Crédits ECTS",
            "Page Web",
            "Diplôme ou formation préparée",
            "Service de rattachement",
            "Discipline SISE 1",
            "Secteur disciplinaire SISE 1",
            "Discipline SISE 2",
            "Secteur disciplinaire SISE 2",
            "Discipline SISE 3",
            "Secteur disciplinaire SISE 3",
            "Discipline SISE 4",
            "Secteur disciplinaire SISE 4",
            "Discipline SISE 5",
            "Secteur disciplinaire SISE 5",
            "Discipline CNU 1",
            "Discipline CNU 2",
            "Discipline CNU 3",
            "Discipline CNU 4",
            "Discipline CNU 5",
            "Domaine disciplinaire HCERES 1",
            "Sous domaine HCERES 1",
            "Domaine disciplinaire HCERES 2",
            "Sous domaine HCERES 2",
            "Domaine disciplinaire HCERES 3",
            "Sous domaine HCERES 3",
            "Domaine disciplinaire HCERES 4" ,
            "Sous domaine HCERES 4",
            "Domaine disciplinaire HCERES 5",
            "Sous domaine HCERES 5",
            "Mots-clés",
            "Thème transverse 1",
            "Thème transverse 2",
            "Effectif des diplômés",
            "Débouché possible 1",
            "Débouché possible 2",
            "Débouché possible 3",
            "Débouché possible 4",
            "Débouché possible 5",
            "Code interne d'UF"
        ];
        return $header;
    }

    public function getHeaderLabo()
    {
        $header = [
            "Code UAI",
            "Nom établissement",
            "Service de rattachement",
            "Type de l'UR",
            "Code numérique de l'UR",
            "Nom de l'UR",
            "Sigle de L'UR",
            "Autres établissement porteurs",
            "Nom de l’adresse de l’UR",
            "Latitude",
            "Longitude",
            "Adresse de l'UR",
            "Complement d'adresse de l'UR",
            "Ville de l'UR",
            "Code postal de l'UR",
            "Cedex de l'UR",
            "Région de l'UR",
            "Pays de l'UR",
            "Page Web 1",
            "Page Web 2",
            "Page Web 3",
            "Email de contact",
            "Ecole doctorale",
            "Discipline SISE 1",
            "Secteur disciplinaire SISE 1",
            "Discipline SISE 2",
            "Secteur disciplinaire SISE 2",
            "Discipline SISE 3",
            "Secteur disciplinaire SISE 3",
            "Discipline SISE 4",
            "Secteur disciplinaire SISE 4",
            "Discipline SISE 5",
            "Secteur disciplinaire SISE 5",
            "Discipline CNU 1",
            "Discipline CNU 2",
            "Discipline CNU 3",
            "Discipline CNU 4",
            "Discipline CNU 5",
            "Domaine disciplinaire HCERES 1",
            "Sous domaine HCERES 1",
            "Domaine disciplinaire HCERES 2",
            "Sous domaine HCERES 2",
            "Domaine disciplinaire HCERES 3",
            "Sous domaine HCERES 3",
            "Domaine disciplinaire HCERES 4",
            "Sous domaine HCERES 4",
            "Domaine disciplinaire HCERES 5",
            "Sous domaine HCERES 5",
            "Mots-clés",
            "Thèmes transverse 1",
            "Thèmes transverse 2",
            "Effectif total",
            "Effectif hesam",
            "Axe de recherche 1",
            "Axe de recherche 2",
            "Axe de recherche 3",
            "Axe de recherche 4",
            "Axe de recherche 5",
            "Axe de recherche 6",
            "Axe de recherche 7",
            "Equipement",
            "Prénom et nom du membre 1",
            "Email du membre 1",
            "Prénom et nom du membre 2",
            "Email du membre 2",
            "Prénom et nom du membre 3",
            "Email du membre 3",
            "Prénom et nom du membre 4",
            "Email du membre 4",
            "Prénom et nom du membre 5",
            "Email du membre 5"
        ];

        return $header;
    }

    public function getData(Etablissement  $etablissement, $type) {

        $this->type = $type;
        $this->etablissement = $etablissement;

        if ($type == self::TYPE_FORMATION) {
            return $this->getDataFormation($etablissement);
        } else if ($type == self::TYPE_LABO) {
            return $this->getDataLabo($etablissement);
        } else {
            return array();
        }
    }

    public function getDataFormation(Etablissement $etablissement)
    {
        $formations = $etablissement->getFormation();
        $data = [];
        $dataMerge = [];
        $an = date('Y');
        $etablissementNom = $etablissement->getNom();
        $etablissementCode = $etablissement->getCode();
        //$etablissementCP = $this->getEtablissementCodePostal($etablissement->getEtablissementId());

        // ligne 1 correspond aux noms des champs
        $line = 2;

        foreach ($formations as $index => $formation) {

            $formationId = $formation->getFormationId();
            $localisations = $this->getLocalisations($formationId);

            //plusieurs localisations sont possibles pour une formation
            //afficher dans chaque champ les valeurs des localisations separes par une point virgule
            $localisationsFieldsData = $this->getLocalisationFields($localisations);
            $tag = $this->getFormationTagField($formationId);

            //TODO OK pour version 1, pour version 2 il y a 3  tables des disciplines, alors pour la collecte 2018 il faut adapter export
            $disciplinesSISE = $this->em->getRepository('AppBundle:Discipline')->findDisciplinesByFormationAndType($formationId, 'SISE');
            $disciplinesCNU = $this->em->getRepository('AppBundle:Discipline')->findDisciplinesByFormationAndType($formationId, 'CNU');
            $disciplinesHCERES = $this->em->getRepository('AppBundle:Discipline')->findDisciplinesByFormationAndType($formationId, 'HCERES');

            //var_dump($tag); die;

            $data[$index] = [
                $an,
                $etablissementCode,
                $etablissementNom,
                (isset($localisationsFieldsData['nom'])?$localisationsFieldsData['nom']:null),
                (isset($localisationsFieldsData['lat'])?$localisationsFieldsData['lat']:null),
                (isset($localisationsFieldsData['long'])?$localisationsFieldsData['long']:null),
                (isset($localisationsFieldsData['adresse'])?$localisationsFieldsData['adresse']:null),
                (isset($localisationsFieldsData['complementAdresse'])?$localisationsFieldsData['complementAdresse']:null),
                (isset($localisationsFieldsData['ville'])?$localisationsFieldsData['ville']:null),
                (isset($localisationsFieldsData['code'])?$localisationsFieldsData['code']:null),
                (isset($localisationsFieldsData['cedex'])?$localisationsFieldsData['cedex']:null),
                (isset($localisationsFieldsData['region'])?$localisationsFieldsData['region']:null),
                (isset($localisationsFieldsData['pays'])?$localisationsFieldsData['pays']:null),
                $formation->getTypediplome(),
                $formation->getNiveau(),
                null,//lmd
                null,//modalite,
                null,//Ects,
                $formation->getUrl(),
                $formation->getNom(),
                null,//$formation->getUfr(), BUG
                (isset($disciplinesSISE[0]['domaineId']['nom']))? $disciplinesSISE[0]['domaineId']['nom']:null, //SISE1
                (isset($disciplinesSISE[0]['nom']))? $disciplinesSISE[0]['nom']:null, //SISE1
                (isset($disciplinesSISE[1]['domaineId']['nom']))? $disciplinesSISE[1]['domaineId']['nom']:null, //SISE2
                (isset($disciplinesSISE[1]['nom']))? $disciplinesSISE[1]['nom']:null, //SISE2
                (isset($disciplinesSISE[2]['domaineId']['nom']))? $disciplinesSISE[2]['domaineId']['nom']:null, //SISE3
                (isset($disciplinesSISE[2]['nom']))? $disciplinesSISE[2]['nom']:null, //SISE3
                (isset($disciplinesSISE[3]['domaineId']['nom']))? $disciplinesSISE[3]['domaineId']['nom']:null, //SISE4
                (isset($disciplinesSISE[3]['nom']))? $disciplinesSISE[3]['nom']:null, //SISE4
                (isset($disciplinesSISE[4]['domaineId']['nom']))? $disciplinesSISE[4]['domaineId']['nom']:null, //SISE5
                (isset($disciplinesSISE[4]['nom']))? $disciplinesSISE[4]['nom']:null, //SISE5
                (isset($disciplinesCNU[0]['nom']))? $disciplinesCNU[0]['nom']:null, //CNU1
                (isset($disciplinesCNU[1]['nom']))? $disciplinesCNU[1]['nom']:null, //CNU2
                (isset($disciplinesCNU[2]['nom']))? $disciplinesCNU[2]['nom']:null, //CNU3
                (isset($disciplinesCNU[3]['nom']))? $disciplinesCNU[3]['nom']:null, //CNU4
                (isset($disciplinesCNU[4]['nom']))? $disciplinesCNU[4]['nom']:null, //CNU5
                (isset($disciplinesHCERES[0]['domaineId']['nom']))? $disciplinesHCERES[0]['domaineId']['nom']:null, //HCERES1
                (isset($disciplinesHCERES[0]['nom']))? $disciplinesHCERES[0]['nom']:null, //HCERES1
                (isset($disciplinesHCERES[1]['domaineId']['nom']))? $disciplinesHCERES[1]['domaineId']['nom']:null, //HCERES2
                (isset($disciplinesHCERES[1]['nom']))? $disciplinesHCERES[1]['nom']:null, //HCERES2
                (isset($disciplinesHCERES[2]['domaineId']['nom']))? $disciplinesHCERES[2]['domaineId']['nom']:null, //HCERES3
                (isset($disciplinesHCERES[2]['nom']))? $disciplinesHCERES[2]['nom']:null, //HCERES3
                (isset($disciplinesHCERES[3]['domaineId']['nom']))? $disciplinesHCERES[3]['domaineId']['nom']:null, //HCERES4
                (isset($disciplinesHCERES[3]['nom']))? $disciplinesHCERES[3]['nom']:null, //HCERES4
                (isset($disciplinesHCERES[4]['domaineId']['nom']))? $disciplinesHCERES[4]['domaineId']['nom']:null, //HCERES5
                (isset($disciplinesHCERES[4]['nom']))? $disciplinesHCERES[4]['nom']:null, //HCERES5
                $tag,
                null,
                null,
                $formation->getEffectif(),
                null,
                null,
                null,
                null,
                null,
                null //TODO  add code interne formation recuperer de la bdd
            ];

            $dataMerge = array_merge($dataMerge, $data[$index]);
            $line ++;
        }
        return $data;
    }

    public function getLocalisations($id) {

        if ($this->type == self::TYPE_FORMATION) {
            $localisations = $this->em
                ->getRepository('AppBundle:Localisation')->findAllLocalisationsFormation($id);
        } else if ($this->type == self::TYPE_LABO) {
            $localisations = $this->em
                ->getRepository('AppBundle:Localisation')->findAllLocalisationsLabo($id);
        } else {
            return array();
        }
        return $localisations;
    }

    /*
     * TODO add fields cedex, codePays, complementsAdresse
     */
    private function getLocalisationFields($localisations) {

        $data = [];

        $existNom = false;
        $existLat = false;
        $existLong = false;
        $existAdresse = false;
        $existComplementAdresse = false;
        $existVille = false;
        $existCode = false;
        $existRegion = false;
        $existPays = false;
        $existCedex = false;
        $existCodePays = false;
        foreach ($localisations as $localisation) {
            if ($localisation['nom'] !== null) {
                $nom[] = $localisation['nom'];
                $existNom = true;
            } else {
                $nom[] = null;
            }

            if ($localisation['lat'] !== null) {
                $lat[] = $localisation['lat'];
                $existLat = true;
            } else {
                $lat[] = null;
            }

            if ($localisation['long'] !== null) {
                $long[] = $localisation['long'];
                $existLong = true;
            } else {
                $long[] = null;
            }

            if ($localisation['adresse'] !== null) {
                $adresse[] = $localisation['adresse'];
                $existAdresse = true;
            } else {
                $adresse[] = null;
            }

            if ($localisation['complementAdresse'] !== null) {
                $complementAdresse[] = $localisation['complementAdresse'];
                $existComplementAdresse = true;
            } else {
                $complementAdresse[] = null;
            }

            if ($localisation['ville'] !== null) {
                $ville[] = $localisation['ville'];
                $existVille = true;
            } else {
                $ville[] = null;
            }

            if ($localisation['code'] !== null) {
                $code[] = $localisation['code'];
                $existCode = true;
            } else {
                $code[] = null;
            }

            if ($localisation['region'] !== null) {
                $region[] = $localisation['region'];
                $existRegion = true;
            } else {
                $region[] = null;
            }

            if ($localisation['pays'] !== null) {
                $pays[] = $localisation['pays'];
                $existPays = true;
            } else {
                $pays[] = null;
            }

            if ($localisation['cedex'] !== null) {
                $cedex[] = $localisation['cedex'];
                $existCedex = true;
            } else {
                $cedex[] = null;
            }

            if ($localisation['codePays'] !== null) {
                $codePays[] = $localisation['codePays'];
                $existCodePays = true;
            } else {
                $codePays[] = null;
            }
        }

        if (isset($nom) && $existNom === true) {
            $data['nom'] = join(';', $nom);
        }

        if (isset($lat) && $existLat === true) {
            $data['lat'] = join(';', $lat);
        }

        if (isset($long) && $existLong === true) {
            $data['long'] = join(';', $long);
        }

        if (isset($adresse) && $existAdresse === true) {
            $data['adresse'] = join(';', $adresse);
        }

        if (isset($complementAdresse) && $existComplementAdresse === true) {
            $data['complementAdresse'] = join(';', $complementAdresse);
        }

        if (isset($ville) && $existVille === true) {
            $data['ville'] = join(';', $ville);
        }

        if (isset($code) && $existCode === true) {
            $data['code'] = join(';', $code);
        }

        if (isset($region) && $existRegion === true) {
            $data['region'] = join(';', $region);
        }

        if (isset($pays) && $existPays === true) {
            $data['pays'] = join(';', $pays);
        }

        if (isset($cedex) && $existCedex === true) {
            $data['cedex'] = join(';', $cedex);
        }

        if (isset($codePays) && $existCodePays === true) {
            $data['codePays'] = join(';', $codePays);
        }
        return $data;
    }


    public function getColumnLetter( $number ){
        $prefix = '';
        $suffix = '';
        $prefNum = intval( $number/26 );
        if( $number > 25 ){
            $prefix = $this->getColumnLetter( $prefNum - 1 );
        }
        $suffix = chr( fmod( $number, 26 )+65 );
        return $prefix.$suffix;
    }

    public function getMotsClefsDomaineHCERES() {

        return [
            "MATHS" => "Mathématiques",
            "PHYSIQUE" => "Physique",
            "SCTun" => "Sciences de la terre et de l'univers",
            "CHIMIE" => "Chimie",
            "SCTingen" => "Sciences pour l'ingénieur",
            "STIC" => "Sciences et technologies de l'information et de la communication",
            "BIOLOGIE" => "Biologie, santé",
            "AGRONOMIE" => "Agronomie, écologie, environnement",
            "MO" => "Marchés et organisations",
            "NICS" => "Normes, institutions et comportements sociaux",
            "EES" => "Espace, environnement et sociétés",
            "EHLE" => "Esprit humain, langage, éducation",
            "LTAC" => "Langues, textes, arts et cultures",
            "MAC" => "Mondes anciens et contemporains"
        ];
    }

    public function getMotsClefsDomaineSISE() {

        return [
            "AES" => "Administration économlique et sociale",
            "DSP" => "Droit, sciences politiques",
            "SEG" => "Sciences économiques, gestion",
            "LANGUES" => "Langues",
            "LSLA" => "Lettres, sciences du langage",
            "SHS" => "Sciences humaines et sociales",
            "SVTU" => "Sciences de la vie, de la terre et de l'univers",
            "SFA" => "Sciences fondamentales et applications",
            "STAPS" => "STAPS",
            "MEDECINE" => "Médecine",
            "ODONTO" => "Odontologie",
            "PHARMACIE" => "Pharmacie",
            "INTERDISCI" => "Interdisciplinaire"
        ];
    }

    public function getAbrevationDomaine($nomDomaine) {
        if (array_key_exists($nomDomaine, $tab = array_flip(array_merge($this->getMotsClefsDomaineSISE(), $this->getMotsClefsDomaineHCERES())))) {
            return $tab[$nomDomaine];
        }
        return null;
    }

    public function getFormationTagField($formationId) {

        $tagField = [];
        $tags = $this->em->getRepository('AppBundle:Tag')->getAllTagsForFormation($formationId);
        foreach ($tags as $tag) {
            $tagField[] = $tag['nom'];
        }
        return join(";", $tagField);
    }

    public function getLaboTagField($laboId) {

        $field = [];
        $res = $this->em->getRepository('AppBundle:Tag')->getAllTagsForLabo($laboId);
        foreach ($res as $val) {
            $field[] = $val['nom'];
        }
        return join(";", $field);
    }

    public function getEcolesDoctorales($laboId) {

        $field = [];
        $res = $this->em->getRepository('AppBundle:Ed')->getAllEcolesDoctorales($laboId);
        foreach ($res as $val) {
            $field[] = $val['code'];
        }
        return join(";", $field);
    }

    public function getLaboEquipementField($laboId) {
        $field = [];
        $res = $this->em->getRepository('AppBundle:Equipement')->getAllEquipements($laboId);
        foreach ($res as $val) {
            $field[] = $val['nom'];
        }
        return join(";", $field);
    }

    public function getEtablissementCodePostal($etablissementId) {

        $cp = [];
        $locs = $this->em->getRepository('AppBundle:Localisation')->findEtablissementLocalisations($etablissementId);

        foreach ($locs as $loc) {
            $cp[] = $loc['code'];
        }

        return join(';', $cp);
    }

    public function getDataLabo(Etablissement $etablissement)
    {
        $labos = $etablissement->getLabo();
        $data = [];
        $dataMerge = [];
        $an = date('Y');
        $etablissementNom = $etablissement->getNom();
        $etablissementCode = $etablissement->getCode();

        // ligne 1 correspond aux noms des champs
        $line = 2;

        foreach ($labos as $index => $labo) {

            $laboId = $labo->getLaboId();
            $localisations = $this->getLocalisations($laboId);

            //plusieurs localisations sont possibles pour une formation
            //afficher dans chaque champ les valeurs des localisations separes par une point virgule
            $localisationsFieldsData = $this->getLocalisationFields($localisations);
            $tag = $this->getLaboTagField($laboId);
            $equipement = $this->getLaboEquipementField($laboId);

            //TODO OK pour version 1, pour version 2 il y a 3  tables des disciplines, alors pour la collecte 2018 il faut adapter export
            $disciplinesSISE = $this->em->getRepository('AppBundle:Discipline')->findDisciplinesByLaboAndType($laboId, 'SISE');
            $disciplinesCNU = $this->em->getRepository('AppBundle:Discipline')->findDisciplinesByLaboAndType($laboId, 'CNU');
            $disciplinesHCERES = $this->em->getRepository('AppBundle:Discipline')->findDisciplinesByLaboAndType($laboId, 'HCERES');

            $ed = $this->getEcolesDoctorales($laboId);
            $axes = $this->em->getRepository('AppBundle:Axe')->findAllAxe($laboId);
            //var_dump($axes); die;


            //TODO données avec les valeur null a faire pour les collettes a partir 2018
            $data[$index] = [
                $etablissementCode,
                $etablissementNom,
                NULL, //ufr BUG supprime ou pas?
                $labo->getType(),
                $labo->getCode(),
                $labo->getNom(),
                $labo->getSigle(),
                $labo->getEtabExt(),
                (isset($localisationsFieldsData['nom']) ? $localisationsFieldsData['nom'] : null),
                (isset($localisationsFieldsData['lat']) ? $localisationsFieldsData['lat'] : null),
                (isset($localisationsFieldsData['long']) ? $localisationsFieldsData['long'] : null),
                (isset($localisationsFieldsData['adresse']) ? $localisationsFieldsData['adresse'] : null),
                (isset($localisationsFieldsData['complementAdresse']) ? $localisationsFieldsData['complementAdresse'] : null),
                (isset($localisationsFieldsData['ville']) ? $localisationsFieldsData['ville'] : null),
                (isset($localisationsFieldsData['code']) ? $localisationsFieldsData['code'] : null),
                (isset($localisationsFieldsData['cedex']) ? $localisationsFieldsData['cedex'] : null),
                (isset($localisationsFieldsData['region']) ? $localisationsFieldsData['region'] : null),
                (isset($localisationsFieldsData['pays']) ? $localisationsFieldsData['pays'] : null),
                $labo->getLien(),
                $labo->getLien2(),
                $labo->getLien3(),
                $labo->getMailContact(),
                (isset($ed) ? $ed : null),
                (isset($disciplinesSISE[0]['domaineId']['nom'])) ? $disciplinesSISE[0]['domaineId']['nom'] : null, //SISE1
                (isset($disciplinesSISE[0]['nom'])) ? $disciplinesSISE[0]['nom'] : null, //SISE1
                (isset($disciplinesSISE[1]['domaineId']['nom'])) ? $disciplinesSISE[1]['domaineId']['nom'] : null, //SISE2
                (isset($disciplinesSISE[1]['nom'])) ? $disciplinesSISE[1]['nom'] : null, //SISE2
                (isset($disciplinesSISE[2]['domaineId']['nom'])) ? $disciplinesSISE[2]['domaineId']['nom'] : null, //SISE3
                (isset($disciplinesSISE[2]['nom'])) ? $disciplinesSISE[2]['nom'] : null, //SISE3
                (isset($disciplinesSISE[3]['domaineId']['nom'])) ? $disciplinesSISE[3]['domaineId']['nom'] : null, //SISE4
                (isset($disciplinesSISE[3]['nom'])) ? $disciplinesSISE[3]['nom'] : null, //SISE4
                (isset($disciplinesSISE[4]['domaineId']['nom'])) ? $disciplinesSISE[4]['domaineId']['nom'] : null, //SISE5
                (isset($disciplinesSISE[4]['nom'])) ? $disciplinesSISE[4]['nom'] : null, //SISE5
                (isset($disciplinesCNU[0]['nom'])) ? $disciplinesCNU[0]['nom'] : null, //CNU1
                (isset($disciplinesCNU[1]['nom'])) ? $disciplinesCNU[1]['nom'] : null, //CNU2
                (isset($disciplinesCNU[2]['nom'])) ? $disciplinesCNU[2]['nom'] : null, //CNU3
                (isset($disciplinesCNU[3]['nom'])) ? $disciplinesCNU[3]['nom'] : null, //CNU4
                (isset($disciplinesCNU[4]['nom'])) ? $disciplinesCNU[4]['nom'] : null, //CNU5
                (isset($disciplinesHCERES[0]['domaineId']['nom'])) ? $disciplinesHCERES[0]['domaineId']['nom'] : null, //HCERES1
                (isset($disciplinesHCERES[0]['nom'])) ? $disciplinesHCERES[0]['nom'] : null, //HCERES1
                (isset($disciplinesHCERES[1]['domaineId']['nom'])) ? $disciplinesHCERES[1]['domaineId']['nom'] : null, //HCERES2
                (isset($disciplinesHCERES[1]['nom'])) ? $disciplinesHCERES[1]['nom'] : null, //HCERES2
                (isset($disciplinesHCERES[2]['domaineId']['nom'])) ? $disciplinesHCERES[2]['domaineId']['nom'] : null, //HCERES3
                (isset($disciplinesHCERES[2]['nom'])) ? $disciplinesHCERES[2]['nom'] : null, //HCERES3
                (isset($disciplinesHCERES[3]['domaineId']['nom'])) ? $disciplinesHCERES[3]['domaineId']['nom'] : null, //HCERES4
                (isset($disciplinesHCERES[3]['nom'])) ? $disciplinesHCERES[3]['nom'] : null, //HCERES4
                (isset($disciplinesHCERES[4]['domaineId']['nom'])) ? $disciplinesHCERES[4]['domaineId']['nom'] : null, //HCERES5
                (isset($disciplinesHCERES[4]['nom'])) ? $disciplinesHCERES[4]['nom'] : null, //HCERES5
                $tag,
                null,
                null,
                $labo->getEffectif(),
                $labo->getEffectifHesam(),
                (isset($axes[0]['nom'])) ? $axes[0]['nom'] : null, // TODO axe de recherche 1
                (isset($axes[1]['nom'])) ? $axes[1]['nom'] : null, // TODO axe de recherche 2
                (isset($axes[2]['nom'])) ? $axes[2]['nom'] : null, // TODO axe de recherche 3
                (isset($axes[3]['nom'])) ? $axes[3]['nom'] : null, // TODO axe de recherche 4
                (isset($axes[4]['nom'])) ? $axes[4]['nom'] : null, // TODO axe de recherche 5
                (isset($axes[5]['nom'])) ? $axes[5]['nom'] : null, // TODO axe de recherche 6
                (isset($axes[6]['nom'])) ? $axes[6]['nom'] : null, // TODO axe de recherche 7
                (isset($equipement) ? $equipement : null), // TODO équipement
                null, //Prénom et nom du membre 1
                null, //Email du membre 1
                null, //Prénom et nom du membre 2
                null, //Email du membre 2
                null, //Prénom et nom du membre 3
                null, //Email du membre 3
                null, //Prénom et nom du membre 4
                null, //Email du membre 4
                null, //Prénom et nom du membre 5
                null, //Email du membre 5
            ];

            $dataMerge = array_merge($dataMerge, $data[$index]);
            $line ++;
        }
        return $data;
    }

}