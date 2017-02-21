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

class ImportCategoriesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('import:csv:cat') // bin console/import:csv:cat
            ->setDescription('Import des secteurs, categories, code Rome du fichier métier CSV');
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
                $codeSousDomaine = $codeDomaine.$data[1];
                $codeRome = $codeSousDomaine.$data[2];
                $libelle = utf8_encode($data[3]);

                if ($data[0] != $col) {
                    if ($data[1] != '' or $data[2] != '') {
                        $output->writeln('Something went wrong!');
                    }
                    $col = $data[0];
                    $col1 = '';
                    $col2 = '';

                    $secteur = $em->getRepository('AppBundle:Secteur')
                        ->findOneByCode($codeDomaine);

                    //si le secteur n'esiste pas  alors on cree un
                    if(!is_object($secteur)){
                        $secteur = new Secteur();
                        $secteur->setCode($codeDomaine);
                        $secteur->setNom($libelle);
                        $em->persist($secteur);
                    }
                } else {
                    if ($data[1] != $col1) {
                        if ($data[2] != '') {
                            $output->writeln('Something went wrong!');
                        }
                        $col1 = $data[1];
                        $col2 = '';

                        $categorie = $em->getRepository('AppBundle:Categorie')
                            ->findOneByCode($codeSousDomaine);

                        //si la categorie n'esiste pas alors on cree une
                        if(!is_object($categorie)){
                            $categorie = new Categorie();
                            $categorie->setCode($codeSousDomaine);
                            $categorie->setNom($libelle);
                            $categorie->setSecteur($secteur);
                            $em->persist($categorie);
                        }

                    } else {
                        if ($data[2] != $col2) {
                            $souscategorie = $em->getRepository('AppBundle:Souscategorie')
                                ->findOneByCode($codeRome);

                            //si le code rome  n'esiste pas alors on cree un
                            if(!is_object($souscategorie)){
                                $souscategorie = new Souscategorie();
                                $souscategorie->setCode($codeRome);
                                $souscategorie->setNom($libelle);
                                $souscategorie->setCategorie($categorie);
                                $em->persist($souscategorie);
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