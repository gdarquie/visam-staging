<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Discipline;
use AppBundle\Repository\DisciplineRepository;
use AppBundle\Entity\Etablissement;
use AppBundle\Repository\EtablissementRepository;

class LaboType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('etabExt')
            ->add('lien')
            ->add('mailcontact')
            ->add('responsable')
            ->add('description')
            ->add('code')
            ->add('type')
            ->add('effectif')
            ->add('effectifHesam')
            ->add('sigle')
//            ->add('lien2')
//            ->add('lien3')
            ->add('uai')
            ->add('axes')
//            ->add('membre')
            // ->add('theme')
            // ->add('ufr')
            // ->add('localisation')
            // ->add('formation')
            ->add('discipline', EntityType::class, array(
                'class' => 'AppBundle:Discipline',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function(DisciplineRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ))
            ->add('etablissement', EntityType::class, array(
                'class' => 'AppBundle:Etablissement',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function(EtablissementRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ))
            // ->add('equipement')
            // ->add('ed')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Labo'
        ));
    }
}
