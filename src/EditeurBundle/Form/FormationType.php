<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use AppBundle\Entity\Discipline;
use AppBundle\Repository\DisciplineRepository;
use AppBundle\Entity\Etablissement;
use AppBundle\Repository\EtablissementRepository;

use AppBundle\Entity\Tag;
use AppBundle\Repository\TagRepository;

class FormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('url')
            ->add('annee')
            ->add('niveau', ChoiceType::class, array(
                'choices'  => array(
                    'Bac +1' => 'Bac +1',
                    'Bac +2' => 'Bac +2',
                    'Bac +3' => 'Bac +3',
                    'Bac +4' => 'Bac +4',
                    'Bac +5' => 'Bac +5',
                    'Bac +6' => 'Bac +6',
                    'Bac +7' => 'Bac +7',
                    'Bac +8' => 'Bac +8',
                    'Licence 1' => 'Licence 1',
                    'Licence 2' => 'Licence 2',
                    'Licence 3' => 'Licence 3',
                    'Master 1' => 'Master 1',
                    'Master 2' => 'Master 2',
                    'Doctorat' => 'Doctorat',
                    'Sans objet' => 'Sans objet'
                ),
            ))
            ->add('lmd', ChoiceType::class, array(
                'choices'  => array(
                    'Licence 1' => 'Licence 1',
                    'Licence 2' => 'Licence 2',
                    'Licence 3' => 'Licence 3',
                    'Master 1' => 'Master 1',
                    'Master 2' => 'Master 2',
                    'Doctorat' => 'Doctorat',
                    'Sans objet' => 'Sans objet'
                ),
            ))
            ->add('typediplome')
            ->add('effectif')
            ->add('lien2')
//            ->add('lien3')
            ->add('responsable')
        //     ->add('membre')
//            ->add('tag', EntityType::class, array(
//                'class' => 'AppBundle:Tag',
////                'multiple' => true,
//                'choice_label' => 'nom',
//                'query_builder' => function(TagRepository $repo) {
//                    return $repo->createAlphabeticalQueryBuilder();
//                }
//            ))
        //     ->add('theme')
        //     ->add('localisation')
        //     ->add('labo')

             ->add('etablissement', EntityType::class, array(
                'class' => 'AppBundle:Etablissement',
                'multiple' => true,
                'by_reference' => false,
                'choice_label' => 'nom',
                'query_builder' => function(EtablissementRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ))
        //     ->add('metier')
            ->add('tag')
            ->add('discipline', EntityType::class, array(
                'class' => 'AppBundle:Discipline',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function(DisciplineRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Formation'
        ));
    }
}
