<?php
namespace EditeurBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Liuggio\ExcelBundle\Factory;
use AppBundle\Entity\Etablissement;



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

    public function export(Etablissement $etablissement, $type)
    {
        $this->type = $type;
        $this->etablissement = $etablissement;

        try {
            if ($this->type == self::TYPE_FORMATION) {
                $this->exportFormation();
            } else if ($this->type == self::TYPE_LABO) {
                $this->exportLabo();
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $this->log->warning('Erreur technique inattendue : '.$e->getMessage());
            return false;
        }

        return true;
    }
    /*
        public function exportFormation()
        {
            $phpExcelObject = $this->factory->createPHPExcelObject();

            $phpExcelObject->getProperties()->setCreator("heSam")
                ->setLastModifiedBy("Application Visam")
                ->setTitle("La collecte des données formations en format XLS")
                ->setSubject("La collecte des données formations en format XLS")
                ->setDescription("La collecte des données formations en format XLS")
                ->setKeywords("Collecte formations")
                ->setCategory("Collecte");

            $header = $this->getHeaderFormation();
            $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
            $ln = 1;

            foreach ($header as $key => $value) {

                $cell = $this->getColumnLetter(0);

                $activeSheet->setCellValue($cell.$ln, $value);
            }

            $phpExcelObject->getActiveSheet()->setTitle('Formations Diplômes');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $phpExcelObject->setActiveSheetIndex(0);

            // create the writer
            $writer = $this->factory->createWriter($phpExcelObject, 'Excel5');
            // create the response
            $response = $this->factory->createStreamedResponse($writer);

            $filname = date('Y').'_collecte_formations_'.$this->etablissement.'.xls';
            // adding headers
            $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                $filname
            );
            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Cache-Control', 'maxage=1');
            $response->headers->set('Content-Disposition', $dispositionHeader);

            return $response;
        }
    */
    public function writeExcelForLabo()
    {
        $phpExcelObject = $this->factory->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("heSam")
            ->setLastModifiedBy("Application Visam")
            ->setTitle("La collecte des données labos en format XLS")
            ->setSubject("La collecte des données labos en format XLS")
            ->setDescription("La collecte des données labos en format XLS")
            ->setKeywords("Collecte labos")
            ->setCategory("Collecte");

        $header = $this->getHeaderLabo();
        $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
        $ln = 1;
        foreach ($header as $key => $value) {
            $activeSheet->setCellValue($value.$ln, $key);
        }

        $phpExcelObject->getActiveSheet()->setTitle('Unités Recherche');

        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        return $writer = $this->factory->createWriter($phpExcelObject, 'Excel5');


        // create the response
        $response = $this->factory->createStreamedResponse($writer);

        $filname = date('Y').'_collecte_UR_'.$this->etablissement.'.xls';
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filname
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;

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
            "Rays",
            "Type diplôme",
            "Niv. Bac +",
            "Parcours LMD",
            "Modalités de formation",
            "Crédits ECTS",
            "Page Web",
            "Diplôme ou formation préparée",
            "Service de rattachement",
            "Discipline SISE 1",
            "Secteur discipline SISE 1",
            "Discipline SISE 2",
            "Secteur discipline SISE 2",
            "Discipline SISE 3",
            "Secteur discipline SISE 3",
            "Discipline SISE 4",
            "Secteur discipline SISE 4",
            "Discipline SISE 5",
            "Secteur discipline SISE 5",
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
            "Thèmes transverses 1",
            "Thèmes transverses 2",
            "Effectif des diplômés",
            "Débouché possible 1",
            "Débouché possible 2",
            "Débouché possible 3",
            "Débouché possible 4",
            "Débouché possible 5",
        ];
        /*
        $header = [
            "Année" => 'A',
            "Code UAI" => 'B',
            "Nom établissement" => 'C',
            "Code postal" => 'D',
            "Nom du centre" => 'E',
            "Latitude" => 'F',
            "Longitude" => 'G',
            "Adresse" => 'H',
            "Ville de l'UF" => 'I',
            "Code postal de l'UF" => 'J',
            "Région" => 'K',
            "Type diplôme" => 'L',
            "Niv. Bac +" => 'M',
            "Parcours LMD" => 'N',
            "Modalités de formation" => 'O',
            "Crédits ECTS" => 'P',
            "Page Web" => 'Q',
            "Diplôme ou formation préparée" => 'R',
            "Service de rattachement" => 'S',

            "Discipline SISE 1" => 'T',
            "Secteur discipline SISE 1" => 'U',
            "Discipline SISE 2" => 'V',

            "Secteur discipline SISE 2" => 'W',
            "Discipline SISE 3" => 'X',
            "Secteur discipline SISE 3" => 'Y',

            "Discipline SISE 4" => 'Z',
            "Secteur discipline SISE 4" => 'AA',
            "Discipline SISE 5" => 'AB',

            "Secteur discipline SISE 5" => 'AC',
            "Discipline CNU 1" => 'AD',
            "Discipline CNU 2" => 'AF',

            "Discipline CNU 3" => 'AG',
            "Discipline CNU 4" => 'AH',
            "Discipline CNU 5" => 'AI',

            "Domaine disciplinaire HCERES 1" => 'AJ',
            "Sous domaine HCERES 1" => 'AK',
            "Domaine disciplinaire HCERES 2" => 'AL',

            "Sous domaine HCERES 2" => 'AM',
            "Domaine disciplinaire HCERES 3" => 'AN',
            "Sous domaine HCERES 3" => 'AO',

            "Domaine disciplinaire HCERES 4" => 'AP',
            "Sous domaine HCERES 4" => 'AQ',
            "Domaine disciplinaire HCERES 5" => 'AR',

            "Sous domaine HCERES 5" => 'AS',
            "Mots-clés" => 'AT',
            "Thèmes transverses 1" => 'AU',

            "Thèmes transverses 2" => 'AV',
            "Effectif des diplômés" => 'AW',

            "Débouché possible 1" => 'AX',
            "Débouché possible 2" => 'AY',
            "Débouché possible 3" => 'AZ',
            "Débouché possible 4" => 'BA',
            "Débouché possible 5" => 'BB',
        ];
*/

        return $header;
    }

    public function getHeaderLabo()
    {
        $header = [
            "Code UAI" => 'A',
            "Nom établissement" => 'B',
            "Service de rattachement" => 'C',
            "Type de l'UR" => 'D',
            "Code numérique de l'UR" => 'E',
            "Nom de l'UR" => 'F',
            "Sigle de L'UR" => 'G',
            "Autres établissement porteurs" => 'H',
            "Latitude" => 'I',
            "Longitude" => 'J',
            "Adresse de l'UR" => 'K',
            "Ville de l'UR" => 'L',
            "Code postal de l'UR" => 'M',
            "Région de l'UR" => 'N',
            "Page Web 1" => 'O',
            "Page Web 2" => 'P',
            "Page Web 3" => 'Q',
            "Email du contact" => 'R',
            "Ecole doctorale" => 'S',
            "Discipline SISE 1" => 'T',
            "Secteur discipline SISE 1" => 'U',
            "Discipline SISE 2" => 'V',
            "Secteur discipline SISE 2" => 'W',
            "Discipline SISE 3" => 'X',
            "Secteur discipline SISE 3" => 'Y',
            "Discipline SISE 4" => 'Z',
            "Secteur discipline SISE 4" => 'AA',
            "Discipline SISE 5" => 'AB',
            "Secteur discipline SISE 5" => 'AC',
            "Discipline CNU 1" => 'AD',

            "Discipline CNU 2" => 'AE',
            "Discipline CNU 3" => 'AF',
            "Discipline CNU 4" => 'AG',
            "Discipline CNU 5" => 'AH',
            "Domaine disciplinaire HCERES 1" => 'AI',
            "Sous domaine HCERES 1" => 'AJ',
            "Domaine disciplinaire HCERES 2" => 'AK',
            "Sous domaine HCERES 2" => 'AL',
            "Domaine disciplinaire HCERES 3" => 'AM',
            "Sous domaine HCERES 3" => 'AN',
            "Domaine disciplinaire HCERES 4" => 'AO',
            "Sous domaine HCERES 4" => 'AP',
            "Domaine disciplinaire HCERES 5" => 'AQ',
            "Sous domaine HCERES 5" => 'AR',
            "Mots-clés" => 'AS',
            "Thèmes transverses 1" => 'AT',
            "Thèmes transverses 2" => 'AU',
            "Effectif total" => 'AV',
            "Effectif hesam" => 'AW',
            "Axe de recherche 1" => 'AX',
            "Axe de recherche 2" => 'AY',
            "Axe de recherche 3" => 'AZ',
            "Axe de recherche 4" => 'BA',
            "Axe de recherche 5" => 'BB',
            "Axe de recherche 6" => 'BC',
            "Axe de recherche 7" => 'BD',
            "Equipement" => 'BE',
            "Prénom et nom du membre 1" => 'BF',
            "Email du membre 1" => 'BG',
            "Prénom et nom du membre 2" => 'BH',
            "Email du membre 2" => 'BI',
            "Prénom et nom du membre 3" => 'BJ',
            "Email du membre 3" => 'BK',
            "Prénom et nom du membre 4" => 'BL',
            "Email du membre 4" => 'BM',
            "Prénom et nom du membre 5" => 'BN',
            "Email du membre 5" => 'BO'
        ];

        return $header;
    }

    public function getData(Etablissement  $etablissement, $type) {

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
                (isset($disciplinesSISE[0]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesSISE[0]['domaineId']['nom'])):null, //SISE1
                (isset($disciplinesSISE[0]['abreviation']))? $disciplinesSISE[0]['abreviation']:null, //SISE1
                (isset($disciplinesSISE[1]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesSISE[1]['domaineId']['nom'])):null, //SISE2
                (isset($disciplinesSISE[1]['abreviation']))? $disciplinesSISE[1]['abreviation']:null, //SISE2
                (isset($disciplinesSISE[2]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesSISE[2]['domaineId']['nom'])):null, //SISE3
                (isset($disciplinesSISE[2]['abreviation']))? $disciplinesSISE[2]['abreviation']:null, //SISE3
                (isset($disciplinesSISE[3]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesSISE[3]['domaineId']['nom'])):null, //SISE4
                (isset($disciplinesSISE[3]['abreviation']))? $disciplinesSISE[3]['abreviation']:null, //SISE4
                (isset($disciplinesSISE[4]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesSISE[4]['domaineId']['nom'])):null, //SISE5
                (isset($disciplinesSISE[4]['abreviation']))? $disciplinesSISE[4]['abreviation']:null, //SISE5
                (isset($disciplinesCNU[0]['nom']))? $disciplinesCNU[0]['nom']:null, //CNU1
                (isset($disciplinesCNU[1]['nom']))? $disciplinesCNU[1]['nom']:null, //CNU2
                (isset($disciplinesCNU[2]['nom']))? $disciplinesCNU[2]['nom']:null, //CNU3
                (isset($disciplinesCNU[3]['nom']))? $disciplinesCNU[3]['nom']:null, //CNU4
                (isset($disciplinesCNU[4]['nom']))? $disciplinesCNU[4]['nom']:null, //CNU5
                (isset($disciplinesHCERES[0]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesHCERES[0]['domaineId']['nom'])):null, //HCERES1
                (isset($disciplinesHCERES[0]['abreviation']))? $disciplinesHCERES[0]['abreviation']:null, //HCERES1
                (isset($disciplinesHCERES[1]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesHCERES[1]['domaineId']['nom'])):null, //HCERES2
                (isset($disciplinesHCERES[1]['abreviation']))? $disciplinesHCERES[1]['abreviation']:null, //HCERES2
                (isset($disciplinesHCERES[2]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesHCERES[2]['domaineId']['nom'])):null, //HCERES3
                (isset($disciplinesHCERES[2]['abreviation']))? $disciplinesHCERES[2]['abreviation']:null, //HCERES3
                (isset($disciplinesHCERES[3]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesHCERES[3]['domaineId']['nom'])):null, //HCERES4
                (isset($disciplinesHCERES[3]['abreviation']))? $disciplinesHCERES[3]['abreviation']:null, //HCERES4
                (isset($disciplinesHCERES[4]['domaineId']['nom']))? $this->getAbrevationDomaine(($disciplinesHCERES[4]['domaineId']['nom'])):null, //HCERES5
                (isset($disciplinesHCERES[4]['abreviation']))? $disciplinesHCERES[4]['abreviation']:null, //HCERES5
                $tag,
                null,
                null,
                $formation->getEffectif(),
                null,
                null,
                null,
                null,
                null
            ];

            $dataMerge = array_merge($dataMerge, $data[$index]);
            $line ++;
        }
        return $data;
    }

    public function getLocalisations($formationId) {

        $localisations = $this->em
            ->getRepository('AppBundle:Localisation')->findAllLocalisations($formationId);

        return $localisations;
    }

    /*
     * TODO add fields cedex, codePays, complementsAdresse
     */
    private function getLocalisationFields($localisations) {

        $data = [];

        foreach ($localisations as $localisation) {

            $nom[] = ($localisation['nom'] !== null)?$localisation['nom']:'';
            $lat[] = ($localisation['lat'] !== null)?$localisation['lat']:'';
            $long[] = ($localisation['long'] !== null)?$localisation['long']:'';
            $adresse[] = ($localisation['adresse'] !== null)?$localisation['adresse']:'';

            //$complementAdresse[] = ($localisation['complementsAdresse']== null)?$localisation['complementsAdresse']:'';

            $ville[] = ($localisation['ville'] !== null)?$localisation['ville']:'';
            $code[] = ($localisation['code'] !== null)?$localisation['code']:'';
            $region[] = ($localisation['region'] !== null)?$localisation['region']:'';
            $pays[] = ($localisation['pays'] !== null)?$localisation['pays']:'';
            $cedex[] = ($localisation['cedex'] !== null)?$localisation['cedex']:'';
            $codePays[] = ($localisation['codePays'] !== null)?$localisation['codePays']:'';

        }

        if (isset($nom)) {
            $data['nom'] = join(';', $nom);
        }

        if (isset($lat)) {
            $data['lat'] = join(';', $lat);
        }

        if (isset($long)) {
            $data['long'] = join(';', $long);
        }

        if (isset($adresse)) {
            $data['adresse'] = join(';', $adresse);
        }

        if (isset($complementAdresse)) {
            $data['complementAdresse'] = join(';', $complementAdresse);
        }

        if (isset($ville)) {
            $data['ville'] = join(';', $ville);
        }

        if (isset($code)) {
            $data['code'] = join(';', $code);
        }

        if (isset($region)) {
            $data['region'] = join(';', $region);
        }

        if (isset($pays)) {
            $data['pays'] = join(';', $pays);
        }

        if (isset($cedex)) {
            $data['cedex'] = join(';', $cedex);
        }

        if (isset($codePays)) {
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

    public function getEtablissementCodePostal($etablissementId) {

        $cp = [];
        $locs = $this->em->getRepository('AppBundle:Localisation')->findEtablissementLocalisations($etablissementId);

        foreach ($locs as $loc) {
            $cp[] = $loc['code'];
        }

        return join(';', $cp);
    }


}