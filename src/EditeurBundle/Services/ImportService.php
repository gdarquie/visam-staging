<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 23/03/2017
 * Time: 18:01
 */

namespace EditeurBundle\Services;

use Doctrine\ORM\EntityManager;
use EditeurBundle\Services\Logs;
use Liuggio\ExcelBundle\Factory;
use AppBundle\Entity\Etablissement;
use AppBundle\Entity\Formation;
use AppBundle\Entity\Tag;

class ImportService
{
    protected $em;
    protected $log;
    protected $factory;
    protected $type;
    protected $etablissement;
    protected $tabComparaison = null;
    protected $tabCheckDoublons = null;
    protected $tabDisciplineHceres = null;
    protected $tabDisciplineSise = null;
    protected $tabDisciplineCnu = null;
    protected $tabTags = null;

    //nombre collonnes requis pour un fichier de type  formations
    const REQUIRED_NUMBER_1 = 40;
    //nombre collonnes requis pour un fichier de type laboratoires
    const REQUIRED_NUMBER_2 = 40;
    const CSV_TYPE_FORMATION = 1;
    const CSV_TYPE_LABO = 2;
    const COMMIT_STEP = 5;

    public function __construct(EntityManager $em, Logs $log, Factory $factory)
    {
        $this->em = $em;
        $this->log = $log;
        $this->factory = $factory;
    }

    public function import(Etablissement $etablissement, $type, $file)
    {
        $this->type = $type;
        $this->etablissement = $etablissement;

        $formattedData = $this->getData($file);

        if (!$checkedData = $this->checkData($formattedData)) {
            return false;
        }
        if (!$importation = $this->importData($formattedData)) {
            return false;
        }
        return true;
    }

    public function getData($file)
    {
        $pathParts = pathinfo($file);
        $this->log->setAttribute($pathParts['dirname'], $pathParts['filename']);

        if ($pathParts['extension'] == "csv") {
            return $this->getDataFromCsv($file);
        } else if ($pathParts['extension'] == "xls") {
            return $this->getDataFromExcel($file, 'Excel5');
        } else if ($pathParts['extension'] == "xlsx") {
            return $this->getDataFromExcel($file, 'Excel2007');
        } else {
            $this->log->warning("Le fichier  n'est pas au format autorisé.");
            return false;
        }
    }

    public function getDataFromCsv($file)
    {
        $f = fopen($file, 'r');
        $dataArray = [];
        $line = 0;
        while (($rawLine = fgets($f)) !== false) {
            $line++;
            $dataArray[$line] = $this->formatDataCsv($rawLine, $line);
        }
        fclose($f);
        return $dataArray;
    }

    public function formatDataCsv($rawLine, $line)
    {
        $formattedData = [];
        $data = explode(";", $rawLine);

        if ($this->checkNbFields($data, $line)) {

            if ($this->type == self::CSV_TYPE_FORMATION) {
                list(
                    $formattedData['formation']['annee'],
                    $formattedData['etablissement']['code'],
                    $formattedData['etablissement']['nom'],
                    $formattedData['etablissement']['code_postal'], /*E*/, /*F*/,
                    $formattedData['formation']['typeDiplome'],
                    $formattedData['formation']['niveau'],
                    $formattedData['formation']['url'],
                    $formattedData['formation']['nom'],
                    /*K*/,
                    /* domaine_sise_1 */,
                    $formattedData['discipline']['abreviation_sise_1']/*type SISE*/,
                    /* domaine_sise_2 */,
                    $formattedData['discipline']['abreviation_sise_2']/*type SISE*/,
                    /* domaine_sise_3 */,
                    $formattedData['discipline']['abreviation_sise_3']/*type SISE*/,
                    /* domaine_sise_4 */,
                    $formattedData['discipline']['abreviation_sise_4']/*type SISE*/,
                    /* domaine_sise_5 */,
                    $formattedData['discipline']['abreviation_sise_5']/*type SISE*/,
                    $formattedData['discipline']['nom_cnu_1']/*type CNU*/,
                    $formattedData['discipline']['nom_cnu_2']/*type CNU*/,
                    $formattedData['discipline']['nom_cnu_3']/*type CNU*/,
                    $formattedData['discipline']['nom_cnu_4']/*type CNU*/,
                    $formattedData['discipline']['nom_cnu_5']/*type CNU*/,
                    /* domaine_hcere_1 */,
                    $formattedData['discipline']['abreviation_hceres_1']/*type HCERE*/,
                    /* domaine_hcere_2 */,
                    $formattedData['discipline']['abreviation_hceres_2']/*type HCERE*/,
                    /* domaine_hcere_3 */,
                    $formattedData['discipline']['abreviation_hceres_3']/*type HCERE*/,
                    /* domaine_hcere_4 */,
                    $formattedData['discipline']['abreviation_hceres_4']/*type HCERE*/,
                    /* domaine_hcere_5 */,
                    $formattedData['discipline']['abreviation_hceres_5']/*type HCERE*/,
                    $formattedData['tags']['nom']/*variable compose*/,
                    $formattedData['discipline']['nom_nw3_1']/*type NW3*/,
                    $formattedData['discipline']['nom_nw3_2']/*type NW3*/,
                    $formattedData['formation']['effectif']
                    ) = array_map('trim', $data);
            } else if ($this->type == self::CSV_TYPE_LABO) {
                //TODO for Labo
            }
        }
        return $formattedData;
    }

    public function getDataFromExcel($file, $version)
    {
        $dataArray = [];
        $reader = $this->factory->createReader($version);
        $canread = $reader->canRead($file);
        $phpExcelObject = $reader->load($file);
        //on traite que deuzieme onglait
        $worksheet = $phpExcelObject->getSheet(1);
        $contents = $worksheet->toArray(null,true,true,true);
        $highestRow = $worksheet->getHighestRow();
        //$highestColumn = $worksheet->getHighestColumn();
       // $columns = $this->get_range('A', $highestColumn);

        for ($line = 2; $line <= $highestRow; $line++) {
            $dataArray[$line] = $this->formatDataExcel(array_map('trim',$contents[$line]), $line);
        }
        return $dataArray;
    }

    public function formatDataExcel($data, $line)
    {
        $formattedData = [];
//TODO faire pour labo
        if ($this->checkNbFields($data, $line)) {
            $formattedData['formation']['annee'] = $data['A'];
            $formattedData['etablissement']['code'] = $data['B'];
            $formattedData['etablissement']['nom'] = $data['C'];
            $formattedData['etablissement']['code_postal'] = $data['D'];
            /*E*/ /*F*/
            $formattedData['formation']['typeDiplome'] = $data['G'];
            $formattedData['formation']['niveau'] = $data['H'];
            $formattedData['formation']['url'] = $data['I'];
            $formattedData['formation']['nom'] = $data['J'];
            /*K*/
            /* domaine_sise_1 */
            $formattedData['discipline']['abreviation_sise_1'] = $data['M'];
            /* domaine_sise_2 */
            $formattedData['discipline']['abreviation_sise_2'] = $data['O'];
            /* domaine_sise_3 */
            $formattedData['discipline']['abreviation_sise_3'] = $data['Q'];
            /* domaine_sise_4 */
            $formattedData['discipline']['abreviation_sise_4'] = $data['S'];
            /* domaine_sise_5 */
            $formattedData['discipline']['abreviation_sise_5'] = $data['U'];
            $formattedData['discipline']['nom_cnu_1'] = $data['V'];
            $formattedData['discipline']['nom_cnu_2'] = $data['W'];
            $formattedData['discipline']['nom_cnu_3'] = $data['X'];
            $formattedData['discipline']['nom_cnu_4'] = $data['Y'];
            $formattedData['discipline']['nom_cnu_5'] = $data['Z'];
            /* domaine_hceres_1 */
            $formattedData['discipline']['abreviation_hceres_1'] = $data['AB'];
            /* domaine_hceres_2 */
            $formattedData['discipline']['abreviation_hceres_2'] = $data['AD'];
            /* domaine_hcere_3 */
            $formattedData['discipline']['abreviation_hceres_3'] = $data['AF'];
            /* domaine_hceres_4 */
            $formattedData['discipline']['abreviation_hceres_4'] = $data['AH'];
            /* domaine_hceres_5 */
            $formattedData['discipline']['abreviation_hceres_5'] = $data['AJ'];
            $formattedData['tags']['nom'] = $data['AK'];
            $formattedData['discipline']['nom_nw3_1'] = $data['AL'];
            $formattedData['discipline']['nom_nw3_2'] = $data['AM'];
            $formattedData['formation']['effectif'] = $data['AN'];
        }
        return $formattedData;
    }

    public function checkNbFields(array $data, $line)
    {
        $nbFields = count($data);
        if (($this->type == 1 && $nbFields != self::REQUIRED_NUMBER_1) || ($this->type == 2 && $nbFields != self::REQUIRED_NUMBER_2) ) {
            $msg = "Ln $line : Le nombre des colonnes est erroné : " . $nbFields . '-' . ($this->type == 1) ? self::REQUIRED_NUMBER_1 : self::REQUIRED_NUMBER_2;
            $this->log->warning($msg);
            return false;
        }
        return true;
    }

    public function checkData($formattedData)
    {
        $valid = true;

        foreach ($formattedData as $line => $data) {
            //Formation
            if (!$this->checkFormationData($data['formation'], $line)) {
                $valid = false;
            }
            //Etablissement
            if (!$this->checkEtablissementData($data['etablissement'], $line)) {
                $valid = false;
            }
            if (!$this->checkDisciplineData($data['discipline'], $line)) {
                $valid = false;
            }
        }
        return $valid;
    }

    public function checkFormationData($data, $line)
    {
        $valid = true;

        $requiredParams = array('annee', 'typeDiplome', 'niveau', 'nom');
        $checkRequiredParams = $this->checkMandatoryParameters($data, $requiredParams);

        if ($checkRequiredParams['success'] === false) {
            $msg = sprintf('Ln %d : Les champs obligatoires "%s" sont manquants pour les données formation', $line, $checkRequiredParams['param']);
            $this->log->warning($msg);
            $valid = false;
        }
        // verifier format annee
        $pattern = '/^\d{4}$/';
        if ($data['annee'] != '' && !preg_match($pattern, $data['annee'])) {
            $msg = sprintf('Ln %d : Mauvais format de date : "%s"', $line, $data['annee']);
            $this->log->warning($msg);
            $valid = false;
        }
        return $valid;
    }

    public function checkEtablissementData($data, $line)
    {
        $valid = true;

        $requiredParams = array('code', 'nom', 'code_postal');
        $checkRequiredParams = $this->checkMandatoryParameters($data, $requiredParams);

        if ($checkRequiredParams['success'] === false) {
            $msg = sprintf('Ln %d : Les champs obligatoires "%s" sont manquants pour les données etablissement', $line, $checkRequiredParams['param']);
            $this->log->warning($msg);
            $valid = false;
        }

        // TODO verification si l'etablissement demande est bien avec meme id et meme code
        if ($data['code'] != '' && !$this->em->getRepository('AppBundle:Etablissement')->verifyEtablissementByCodeAndId($this->etablissement->getEtablissementId(), $data['code'])) {
            $msg = sprintf('Ln %d : L\'etablissement inconnu avec son identifiant %d et son code %s', $line, $this->etablissement->getEtablissementId(), $data['code']);
            $this->log->warning($msg);
            $valid = false;
        }
        return $valid;
    }

    public function checkDisciplineData($data, $line)
    {
        $valid = true;

        if (!$this->checkDisciplineParameters($data)) {
            $msg = sprintf("Ln %d : Une ou plusieurs valeurs  des disciplines type SISE, CNU et HCERES est/sont absente(s)", $line);
            $this->log->warning($msg);
            $valid = false;
        }

        if (!$this->checkDisciplinesValues($data)) {
            $msg = sprintf("Ln %d : La valeur de discipline est inconue", $line);
            $this->log->warning($msg);
            $valid = false;
        }
        return $valid;
    }

    /**
     * verification la presence les champs oblicatoires pour traitement
     */
    public function checkMandatoryParameters($data, $requiredParams = null)
    {
        $res['success'] = true;

        if ($requiredParams != null) {
            foreach ($data as $key => $val) {
                if (trim($val) == '') {
                    unset($data[$key]);
                }
            }

            $missingParams = array_diff_key(array_flip($requiredParams), $data);

            if (!empty($missingParams)) {
                $missingParamList = implode(', ', array_keys($missingParams));
                $res['success'] = false;
                $res['param'] = $missingParamList;
            }
        }
        return $res;
    }

    public function checkDisciplineParameters($disciplines) {
        //RG au moins un champs pour SISE, CNU et HCERES est présent (en tout 3 champs au minimum)
        //TODO trim avant
        if (($disciplines['abreviation_sise_1'] == ''
                && $disciplines['abreviation_sise_2'] == ''
                && $disciplines['abreviation_sise_3'] == ''
                && $disciplines['abreviation_sise_4'] == ''
                && $disciplines['abreviation_sise_5'] == '')
            || ($disciplines['nom_cnu_1']  == ''
                && $disciplines['nom_cnu_2'] == ''
                && $disciplines['nom_cnu_3'] == ''
                && $disciplines['nom_cnu_4'] == ''
                && $disciplines['nom_cnu_5'] == '')
            || ($disciplines['abreviation_hceres_1'] == ''
                && $disciplines['abreviation_hceres_2'] == ''
                && $disciplines['abreviation_hceres_3'] == ''
                && $disciplines['abreviation_hceres_4'] == ''
                && $disciplines['abreviation_hceres_5'] == '')
        ) {
            return false;
        }
        return true;
    }

    public function checkDisciplinesValues($disciplines)
    {
        for ($i = 1; $i <= 5; $i++) {
            //SISE
            $sise = 'abreviation_sise_'.$i;
            if ($disciplines[$sise] != '') {
                if (!$this->disciplineExists($disciplines[$sise], 'SISE')) {
                    $msg = sprintf('La valeur de discipline SISE "%s" est inconue', $disciplines[$sise]);
                    $this->log->warning($msg);
                    return false;
                }
            }
            $hceres = 'abreviation_hceres_'.$i;
            if ($disciplines[$hceres] != '') {
                if (!$this->disciplineExists($disciplines[$hceres], 'HCERES')) {
                    $msg = sprintf('La valeur de discipline HCERES "%s" est inconue', $disciplines[$hceres]);
                    $this->log->warning($msg);
                    return false;
                }
            }
            $cnu = 'nom_cnu_'.$i;
            if ($disciplines[$cnu] != '') {
                if (!$this->disciplineExists($disciplines[$cnu], 'CNU')) {
                    $msg = sprintf('La valeur de discipline CNU "%s" est inconue', $disciplines[$cnu]);
                    $this->log->warning($msg);
                    return false;
                }
            }
        }
        return true;
    }

    public function importData($formattedData)
    {
        //verifier si la formation ou le labo existe
        //TODO repenser ; prendre en compte qu'aura aussi labos
        $valid = true;

        foreach ($formattedData as $line => $data) {
            try {
                $formation = new Formation();
                $formation->addEtablissement($this->etablissement);
                //$this->etablissement->addFormation($formation);
/*
                if ($objId = $this->getObjId($data['formation'])) {
                    $formation->setObjId($objId);
                } else {
                    $formationId = $formation->getFormationId();
                    $formation->setObjId('F' . $formationId);
                } */
                $formation->setNom($data['formation']['nom']);
                //$formation->setDescription($data['formation']['description']);
                $formation->setUrl($data['formation']['url']);
                $formation->setAnnee($data['formation']['annee']);
                $formation->setNiveau($data['formation']['niveau']);
                $formation->setTypeDiplome($data['formation']['typeDiplome']);
                $formation->setDateCreation(new \DateTime());
                $formation->setLastUpdate(new \DateTime());
                if ($data['formation']['effectif'] != '') {
                    $formation->setEffectif($data['formation']['effectif']);
                }

                for ($i = 1; $i <= 5; $i++) {
                    //SISE
                    $sise = 'abreviation_sise_' . $i;
                    if ($data['discipline'][$sise] != '') {
                        $discipline = $this->em
                            ->getRepository('AppBundle:Discipline')
                            ->findOneByAbreviation($data['discipline'][$sise]);

                        $formation->addDiscipline($discipline);
                    }
                    $hceres = 'abreviation_hceres_' . $i;
                    if ($data['discipline'][$hceres] != '') {
                        $discipline = $this->em
                            ->getRepository('AppBundle:Discipline')
                            ->findOneByAbreviation($data['discipline'][$hceres]);

                        $formation->addDiscipline($discipline);
                    }
                    $cnu = 'nom_cnu_' . $i;
                    if ($data['discipline'][$cnu] != '') {
                        $discipline = $this->em
                            ->getRepository('AppBundle:Discipline')
                            ->findOneByNom($data['discipline'][$cnu]);

                        $formation->addDiscipline($discipline);
                    }
                }

                //Tags
                if ($data['tags']['nom'] !='') {
                    $tags = explode(';', $data['tags']['nom']);

                    foreach ($tags as $value) {
                        //verifier sil est deja dans la base, avant il faut supprimer accents etc..
                        $valueSansAccents = $this->removeAccents($value);
                        if (!$this->tagExists($valueSansAccents)) {
                            $tag = new Tag();
                            $tag->setNom($value);
                            $tag->setDateCreation(new \DateTime());
                            $tag->setLastUpdate(new \DateTime());
                            $this->em->persist($tag);
                            //on ajout nouvelle entree dans tabTags
                            $newTag = array($valueSansAccents => $tag->getTagId());
                            array_merge($this->tabTags, $newTag);
                        } else {
                            $tag = $this->em
                                ->getRepository('AppBundle:Tag')
                                ->find($this->tabTags[$valueSansAccents]);
                        }
                        $formation->addTag($tag);
                    }
                }
                $this->em->persist($formation);
                if ((($line % self::COMMIT_STEP) == 0)) {
                    $this->em->flush();
                }
            } catch (\Exception $e) {
                $this->log->warning('data_error in line : '.$line.' Message : '.$e->getMessage());
                $valid = false;
            }
        }
        $this->em->flush();
        return $valid;
    }

    public function getStrFormation($nom, $typeDiplome, $niveau)
    {
        return $this->removeAccents($nom).$this->removeAccents($typeDiplome).$this->removeAccents($niveau);
    }

    public function removeAccents($str)
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset='utf-8');

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;()#', '', $str); // supprime les autres caractères
        $str = preg_replace("#[\\(\\)\\[\\]\\|\\-\\+\\{\\}_;:, ']+#", '', $str); // supprime les autres caractères
        $str = trim(strtolower($str));
        return $str;
    }

    public function getTabDisciplineSise()
    {
        if ($this->tabDisciplineSise === null) {
            $tabDisciplines = array();
            $disciplines = $this->em->getRepository('AppBundle:Discipline')->findAllDisciplines('SISE');
            foreach ($disciplines as $discipline) {
                $key = $discipline['abreviation'];
                $tabDisciplines[$key] = null;
            }
            $this->tabDisciplineSise = $tabDisciplines;
        }
        return $this->tabDisciplineSise;
    }

    public function getTabDisciplineHceres()
    {
        if ($this->tabDisciplineHceres === null) {
            $tabDisciplines = array();
            $disciplines = $this->em->getRepository('AppBundle:Discipline')->findAllDisciplines('HCERES');
            foreach ($disciplines as $discipline) {
                $key = $discipline['abreviation'];
                $tabDisciplines[$key] = null;
            }
            $this->tabDisciplineHceres = $tabDisciplines;
        }
        return $this->tabDisciplineHceres;
    }

    public function getTabDisciplineCnu()
    {
        if ($this->tabDisciplineCnu === null) {
            $tabDisciplines = array();
            $disciplines = $this->em->getRepository('AppBundle:Discipline')->findAllDisciplines('CNU');
            foreach ($disciplines as $discipline) {
                $key = $discipline['nom'];
                $tabDisciplines[$key] = null;
            }
            $this->tabDisciplineCnu = $tabDisciplines;
        }
        return $this->tabDisciplineCnu;
    }

    public function getTabTags()
    {
        if ($this->tabTags === null) {
            $tag = array();
            $tags = $this->em->getRepository('AppBundle:Tag')->getAllNom();
            foreach ($tags as $value) {
                $key = $this->removeAccents($value['nom']);
                $tag[$key] = $value['tagId'];
            }
            $this->tabTags = $tag;
        }
        return $this->tabTags;
    }

    private function disciplineExists($discipline, $type)
    {
        switch ($type) {
            case 'SISE':
                if ($this->tabDisciplineSise === null) {
                    $this->getTabDisciplineSise();
                }
                return array_key_exists($discipline, $this->tabDisciplineSise);
                break;
            case 'HCERES':
                if ($this->tabDisciplineHceres === null) {
                    $this->getTabDisciplineHceres();
                }
                return array_key_exists($discipline, $this->tabDisciplineHceres);
                break;
            case 'CNU':
                if ($this->tabDisciplineCnu === null) {
                    $this->getTabDisciplineCnu();
                }
                return array_key_exists($discipline, $this->tabDisciplineCnu);
                break;
            default:
                return false;
        }
    }

    private function tagExists($tag)
    {
        if ($this->tabTags === null) {
            $this->getTabTags();
        }
        return array_key_exists($tag, $this->tabTags);
    }

    public function getTabComparaison()
    {
        if ($this->tabComparaison === null) {
            if ($this->type == self::CSV_TYPE_FORMATION) {
                $this->getTabComparaisonFormations();
            } else {
                $this->getTabComparaisonLabo();
            }
        }
        return $this->tabComparaison;
    }

    public function getTabComparaisonFormations()
    {
        $list =  $this->etablissement->getFormation();
        $dataComparaison = [];
        $dataCheckDoublons = [];

        foreach ($list as $val) {
            //TODO changer getFormationId par getObjetId de qu'il est en place
            $str = $this->getStrFormation($val->getNom(), $val->getTypeDiplome(), $val->getNiveau());
            $str2 = $str.$val->getTypeDiplome();
            $dataComparaison[$str] = 'F'.$val->getFormationId();
            $dataCheckDoublons[$str2] = 'F'.$val->getFormationId();
        }

        if (count($list) !== count($dataComparaison)) {
            throw new \Exception('Doublons dans la liste de formation (BDD)');
        }
        $this->tabComparaison = $dataComparaison;
        $this->tabCheckDoublons = $dataCheckDoublons;
        return true;
    }

    //TODO add check doublons
    public function getTabComparaisonLabo()
    {
        $list =  $this->etablissement->getLabo();
        $data = [];

        foreach ($list as $val) {
            //TODO changer getLaboId par getObjetId de qu'il est en place
            $str = $this->getStrFormation($val->getNom());
            $data[$str] = 'L'.$val->getLaboId();
        }

        if (count($list) !== count($data)) {
            throw new \Exception('Doublons dans la liste de labo (BDD)');
        }
        return $data;
    }

    function getObjId($data)
    {
        $strFormation = $this->getStrFormation($data['nom'], $data['typeDiplome'], $data['niveau']);
        if ($this->tabComparaison === null) {
            $this->getTabComparaison();
        }
        if (array_key_exists($strFormation, $this->tabComparaison)) {
            return $this->tabComparaison[$strFormation];
        }
        return false;
    }

}