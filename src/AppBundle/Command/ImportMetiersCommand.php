<?php
// src/AppBundle/Command/GreetCommand.php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use AppBundle\Entity\Metier1;
use AppBundle\Entity\Metier2;
use AppBundle\Entity\Metier3;

class ImportMetiersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('import:csv:cat') // bin console/import:csv:cat
            ->setDescription('Import des metiers et code Rome du fichier métier CSV');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();
        $output->writeln('<comment>Debut : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        // Importation
        $this->import($input, $output);

        $now = new \DateTime();
        $output->writeln('<comment>Fin : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        $file = "data/rome.csv";

        if (($handle = fopen($file, "r")) !== FALSE) {

            $row = 1;
            $col = '';
            $col1 = '';
            $col2 = '';


            $em = $this->getContainer()->get('doctrine')->getManager();

            while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                $codeDomaine = $data[0];
                $codeSousDomaine = utf8_decode(utf8_encode($codeDomaine.$data[1]));
                $codeRome = utf8_decode(utf8_encode($codeSousDomaine.$data[2]));
                $libelle = utf8_decode(utf8_encode($data[3]));

                if ($data[0] != $col) {
                    if ($data[1] != '' or $data[2] != '') {
                        $output->writeln('Something went wrong!');
                    }
                    $col = $data[0];
                    $col1 = '';
                    $col2 = '';

                    $metier1 = $em->getRepository('AppBundle:Metier1')
                        ->findOneByCode($codeDomaine);

                    //si le metier1 n'esiste pas  alors on cree un
                    if(!is_object($metier1)){
                        $metier1 = new Metier1();
                        $metier1->setCode($codeDomaine);
                        $metier1->setNom($libelle);
                        $em->persist($metier1);
                    }
                } else {
                    if ($data[1] != $col1) {
                        if ($data[2] != '') {
                            $output->writeln('Something went wrong!');
                        }
                        $col1 = $data[1];
                        $col2 = '';

                        $metier2 = $em->getRepository('AppBundle:Metier2')
                            ->findOneByCode($codeSousDomaine);

                        //si la metier2 n'esiste pas alors on cree une
                        if(!is_object($metier2)){
                            $metier2 = new Metier2();
                            $metier2->setCode($codeSousDomaine);
                            $metier2->setNom($libelle);
                            $metier2->setMetier1($metier1);
                            $em->persist($metier2);
                        }

                    } else {
                        if ($data[2] != $col2) {
                            $metier3 = $em->getRepository('AppBundle:Metier3')
                                ->findOneByCode($codeRome);

                            //si le code rome  n'esiste pas alors on cree un
                            if(!is_object($metier3)){
                                $metier3 = new Metier3();
                                $metier3->setCode($codeRome);
                                $metier3->setNom($libelle);
                                $metier3->setMetier2($metier2);
                                $em->persist($metier3);
                            }
                            $col2 = $data[2];
                        }
                    }
                }
                $em->flush();
                $row++;
            }

            // Flushing le reste
            // $em->flush();
            $em->clear();

            // Ending the progress bar process
            fclose($handle);
        }
    }
}