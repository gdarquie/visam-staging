<?php

namespace EditeurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class ExportController  extends Controller
{
    const DOSSIER_TYPE_FORMATION = 'formations';
    const DOSSIER_TYPE_LABO = 'laboratoires';
    const TYPE_FORMATION = 'F';
    const TYPE_LABO = 'L';

    /**
     * export formulaire
     *
     * @Route("/export_formulaire", name="export_formulaire")
     * @Method("GET")
     */
    public function exportFormulaireAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $exportService = $this->get('editeur.export.service');
        $type = $request->query->get('type');
        $etab = $request->query->get('id');
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        if ($type == self::TYPE_FORMATION) {
            $header = $exportService->getHeaderFormation();
            $activeSheetName = 'Formations Diplômes';
            $dossier = self::DOSSIER_TYPE_FORMATION;
        } else {
            $header = $exportService->getHeaderLabo();
            $activeSheetName = 'Unités Recherche';
            $dossier = self::DOSSIER_TYPE_LABO;
        }
        $phpExcelObject->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setRGB('FF0000');
        $phpExcelObject->getProperties()->setCreator("heSam")
            ->setLastModifiedBy("Application Visam")
            ->setTitle("La collecte des données labos en format XLS")
            ->setSubject("La collecte des données labos en format XLS")
            ->setDescription("La collecte des données labos en format XLS")
            ->setKeywords("Collecte labos")
            ->setCategory("Collecte");

        $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
        $ln = 1;
        foreach ($header as $key => $value) {

            $cell = $exportService->getColumnLetter($key);

            $activeSheet->setCellValue($cell.$ln, $value);
        }

        $ln ++;

        if ($etablissement = $em->getRepository('AppBundle:Etablissement')->find($etab)) {

            $data = $exportService->getData($etablissement, $type);

            foreach ($data as $rowIndex => $rowValue) {
                foreach ($rowValue as $cellIndex => $value) {
                    $cell = $exportService->getColumnLetter($cellIndex);
                    $activeSheet->setCellValue($cell.$ln, $value);
                }
                $ln ++;
            }
        }

        $phpExcelObject->getActiveSheet()->setTitle($activeSheetName);
        $filname = date('Y').'-'.$dossier.'-'.$etab.'.xls';

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet


        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');

        $response = $this->get('phpexcel')->createStreamedResponse($writer);
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
}