<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Repository\EtablissementRepository;
use AppBundle\Repository\LocalisationRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EdType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $etablissements = $options['etablissements'];
        $localisations = $options['localisations'];

        $builder
            ->add('code')
            ->add('nom')
            ->add('lien')
            ->add('laboExt')
            ->add('etabExt')
            ->add('contact')
            ->add('effectif')
            ->add('membre')
            ->add('localisation', EntityType::class, array(
                'class' => 'AppBundle:Localisation',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function (LocalisationRepository $repo) use ($localisations){
                    return $repo->createQueryBuilder('localisation')
                        ->where('localisation IN(:localisation)')
                        ->setParameter('localisation', $localisations)
                        ->orderBy('localisation.nom', 'ASC')
                        ;
                }
            ))
            ->add('etablissement', EntityType::class, array(
                'class' => 'AppBundle:Etablissement',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function (EtablissementRepository $repo) use ($etablissements){
//                    return $repo->createAlphabeticalQueryBuilderWhereEtab();
                    return $repo->createQueryBuilder('etablissement')
                        ->where('etablissement IN(:etablissement)')
                        ->setParameter('etablissement', $etablissements)
                        ->orderBy('etablissement.nom', 'ASC')
                        ;
                }
            ))
//             ->add('discipline')
             ->add('labo')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {


        $etablissements = [];
        $localisations = [];

        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ed',
            'etablissements' => $etablissements,
            'localisations' => $localisations
        ));
    }
}
