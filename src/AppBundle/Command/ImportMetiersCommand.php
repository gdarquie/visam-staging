<?php
// src/AppBundle/Command/GreetCommand.php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use AppBundle\Entity\Secteur;
use AppBundle\Entity\Categorie;
use AppBundle\Entity\Souscategorie;
use AppBundle\Entity\Metier;

class ImportMetiersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('import:csv:metier')
            ->setDescription('Importations des metiers du fichier CSV');
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
            $rome = '';

            $batchSize = 500;
            $size = count(file($file));

            $em = $this->getContainer()->get('doctrine')->getManager();
            // Starting progress
            $progress = new ProgressBar($output, $size);
            $progress->start();

            while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                if ($data[0] != '' && $data[1] != '' && $data[2] != '') {
                    $codeRome = $data[0] . $data[1] . $data[2];


                    if ($codeRome != $rome) {
                        $souscategorie = $em->getRepository('AppBundle:Souscategorie')
                            ->findOneByCode($codeRome);
                        $rome = $codeRome;
                    }

                    if (!isset($souscategorie)) {

                        $output->writeln('<comment>code rome : ' . $codeRome . ' ---</comment>');
                        $output->writeln('<comment>rome : ' . $rome . ' ---</comment>');
                        $output->writeln('<comment>rox : ' . $row . ' ---</comment>');
                    }


                    if ($data[2] == $col2) {
                        $libelle = utf8_encode($data[3]);
                        $metier = new Metier();
                        $metier->setRome($codeRome);
                        $metier->setNom($libelle);
                        $metier->setSouscategorie($souscategorie);
                        $em->persist($metier);
                    }

                    if (($row % $batchSize) === 0) {

                        $em->flush();
                        // Detaches all objects from Doctrine for memory save
                        //$em->clear();

                        // Advancing for progress display on console
                        $progress->advance($batchSize);

                        $now = new \DateTime();
                        $output->writeln(' of users imported ... | ' . $now->format('d-m-Y G:i:s'));
                    }
                }

                $col = ($data[0] != $col) ? $data[0] : $col;
                $col1 = ($data[1] != $col1) ? $data[1] : $col1;
                $col2 = ($data[2] != $col2) ? $data[2] : $col2;
                $row++;
            }

            // Flushing le reste
            $em->flush();
            $em->clear();


            // Ending the progress bar process
            $progress->finish();
            fclose($handle);
        }
    }
}