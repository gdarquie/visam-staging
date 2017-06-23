<?php

namespace EditeurBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Etablissement;

use EditeurBundle\Form\UploadFileType;

/**
 * télecharger un fichier en format csv
 */

class AjaxController extends Controller
{

    const NB_FIELDS_FORMATION = 40;
    const NB_FIELDS_LABO = 40;
    const DOSSIER_TYPE_FORMATION = 'formations';
    const DOSSIER_TYPE_LABO = 'laboratoires';
    const EXTENTION_AUTHORIZED = 'xlsx';
//    const EXTENTION_AUTHORIZED = array('csv','xls','xlsx');
    const TYPE_FORMATION = 'F';
    const TYPE_LABO = 'L';

    /**
     * un fichier en format csv
     *
     * @Route("/upload", name="upload")
     * @Method("POST")
     */
    public function uploadDocumentAction(Request $request)
    {
        $form = $this->createForm('EditeurBundle\Form\UploadFileType');
        if ($request->isXmlHttpRequest()) {
            $form->handleRequest($request);
            //$data = $form->getData();
            $file = $form['attachment']->getData();
            $type = $form['type']->getData();
            $etab = $form['etablissement']->getData();

            $res['success'] = false;
            $res['code'] = 400;

            if (empty($file) || empty($type) || empty($etab) || $file->getError() > 0) {

                if (empty($file)) {
                    $res['msg'] = 'Le champ obligatoire "fichier" est manquant';
                } else if (empty($type)) {
                    $res['msg'] = 'Le champ obligatoire "type" est manquant';
                } else if (empty($etab)) {
                    $res['msg'] = 'Le champ obligatoire "etablissement" est manquant';
                } else if ($file->getError() > 0) {
                    $errorMsg = $this->codeToMessage($file->getError());
                    $res['msg'] = 'L\'erreur du télechargement du fichier : '.$errorMsg;
                }
                return new JsonResponse($res);
            }

            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, self::EXTENTION_AUTHORIZED)) {
                $res['msg'] = 'Le fichier que vous tentez de télécharger n\'est pas au format autorisé : '.implode(', ', self::EXTENTION_AUTHORIZED);
                $file = null;
                return new JsonResponse($res);
            }

            if (!in_array($type, array(self::TYPE_FORMATION,self::TYPE_LABO))) {
                //$res['msg'] = 'Le type inconnu.';
                //return new JsonResponse($res);
                throw $this->createNotFoundException('Le type inconnu.');
            }
            // check etablissement
            $em = $this->getDoctrine()->getManager();

            if (! $etablissements = $em->getRepository('AppBundle:Etablissement')->find($etab)) {
                throw $this->createNotFoundException('L\etablissement inconnu.');
            }

            $target_dir = $this->container->getParameter('upload_dir');

            /*
               if ($type == self::TYPE_LABO) {
                   $res['msg'] = 'Le fichier de type laboratoire n\'est pas traitée pour le moment. C\'est en cours de développement.';
                   return new JsonResponse($res);
               }
            */

            if ($type == self::TYPE_LABO) {
                $doc_name = self::TYPE_LABO .'-'.$etab.'-'. date('Ymd_His');
            } else {
                $doc_name = self::TYPE_FORMATION .'-'.$etab.'-'.date('Ymd_His');
            }
            $file_name = $doc_name . '.' . $extension;

            $this->rmkdir($target_dir, 0777);
            $file->move($target_dir, $file_name);
            chmod($target_dir . '/' . $file_name, 0777);

            if (!file_exists($target_dir . '/' . $file_name)) {
                $res['msg'] = 'Le fichier non trouvé.';
                return new JsonResponse($res);
            }

            $importService = $this->get('editeur.import.service');

            if (!$importService->import($etablissements, $type, $target_dir . '/' . $file_name)) {
                $message = "L'importation de données echoué.";
                //lire fichier log et supprimer le fichier uploadé et fichier log
                $logFile = $target_dir . '/' . $doc_name . '.log';

                if (file_exists($logFile)) {
                    $res['log'] = $this->getLogInfo($logFile);
                    $res['filename'] = $doc_name . '.log';
                    $message .= " Consulter le fichier log pour plus d'information";
                    //unlink($logFile);
                }
                unlink($target_dir . '/' . $file_name);
                $res['msg'] = $message;
            } else {
                $res['success'] = true;
                $res['code'] = 200;
                $res['msg'] = "l'importation réussie.";
            }

            return new JsonResponse($res);
        } else {
            return $this->render('EditeurBundle:modals:modal_csv_upload.html.twig', array('form' => $form->createView()));
        }
    }

    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;
            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }

    public function rmkdir($path, $mode = 0777)
    {
        $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
        $e = explode("/", ltrim($path, "/"));
        if (substr($path, 0, 1) == "/") {
            $e[0] = "/" . $e[0];
        }
        $c = count($e);
        $cp = $e[0];
        for ($i = 1; $i < $c; $i++) {
            if (!is_dir($cp) && !@mkdir($cp, $mode)) {
                return false;
            }
            $cp .= "/" . $e[$i];
        }
        return @mkdir($path, $mode);
    }

    public function getLogInfo($file) {

        $f = fopen($file, 'r');
        $dataArray = [];
        $line = 0;
        while (($rawLine = fgets($f)) !== false) {
            $dataArray[$line] = $rawLine;
            $line++;
        }
        fclose($f);
        return $dataArray;
    }

    //via de nom du file a traiter
    public function getLogName($file) {
        $pathParts = pathinfo($file);
        return $pathParts['dirname'] . '/' . $pathParts['filename'].'.log';
    }

    /**
     * show log
     *
     * @Route("/show_log", name="show_log")
     * @Method("GET")
     */
    public function showLogAction(Request $request)
    {
        $dir = $this->container->getParameter('upload_dir');
        $filename = $request->query->get('id');

        $infos = $this->getLogInfo($dir.'/'.$filename);

        $html = $this->renderView('EditeurBundle:pdf:erreurs_importation.html.twig', array('informations' => $infos));

        $html2pdf = $this->get('html2pdf_factory')->create();
        $html2pdf->pdf->SetDisplayMode('real');

        $html2pdf->writeHTML($html);
        if (file_exists($dir.'/'.$filename)) {
            unlink($dir . '/' . $filename);
        }
        //Output envoie le document PDF au navigateur internet
        return new Response($html2pdf->Output('nom-du-pdf.pdf'), 200, array('Content-Type' => 'application/pdf'));

    }
}