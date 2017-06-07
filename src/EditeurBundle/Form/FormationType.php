<?php

namespace EditeurBundle\Form;


use AppBundle\Repository\Metier3Repository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use AppBundle\Repository\DisciplineRepository;
use AppBundle\Repository\EtablissementRepository;
use AppBundle\Repository\LocalisationRepository;
use AppBundle\Repository\ThesaurusRepository;

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

        $etablissements = $options['etablissements'];
        $localisations = $options['localisations'];

        $builder
            ->add('nom')
            ->add('description')
            ->add('url')
            ->add('annee')
            ->add('niveau_thesaurus', EntityType::class, array(
                'placeholder' => 'Sélectionner une réponse',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'nom', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByType("niveau");
                }
            ))
            ->add('lmd_thesaurus', EntityType::class, array(
                'placeholder' => 'Sélectionner une réponse',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'nom', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByType("parcours");
                }
            ))
            ->add('ects')
            ->add('modalite_thesaurus', EntityType::class, array(
                'placeholder' => 'Sélectionner une réponse',
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'nom', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByType("modalites");
                }
            ))
            ->add('typediplome_thesaurus', EntityType::class, array(
                'placeholder' => 'Sélectionner une réponse',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'nom', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByType("diplome");
                }
            ))
            ->add('effectif')
            ->add('lien2')
//            ->add('lien3')
//            ->add('responsable')
             ->add('membre', CollectionType::class, [
                'entry_type' => MembreEmbeddedForm::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
//            ->add('tag', EntityType::class, array(
//                'class' => 'AppBundle:Tag',
////                'multiple' => true,
//                'choice_label' => 'nom',
//                'query_builder' => function(TagRepository $repo) {
//                    return $repo->createAlphabeticalQueryBuilder();
//                }
//            ))
        //     ->add('theme')
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
        //     ->add('labo')

            ->add('etablissement', EntityType::class, array(
                'class' => 'AppBundle:Etablissement',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function (EtablissementRepository $repo) use ($etablissements){
                    return $repo->createQueryBuilder('etablissement')
                        ->where('etablissement IN(:etablissement)')
                        ->setParameter('etablissement', $etablissements)
                        ->orderBy('etablissement.nom', 'ASC')
                        ;
                }
            ))
            ->add('metier', EntityType::class, array(
                'class' => 'AppBundle:Metier3',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function (Metier3Repository $repo){
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ))
            ->add('tag')
            ->add('cnu', EntityType::class, array(
                'class' => 'AppBundle:Discipline',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function(DisciplineRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilderByType('CNU');
                }
            ))
            ->add('sise', EntityType::class, array(
                'class' => 'AppBundle:Discipline',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function(DisciplineRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilderByType('SISE');
                }
            ))
            ->add('hceres', EntityType::class, array(
                'class' => 'AppBundle:Discipline',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function(DisciplineRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilderByType('HCERES');
                }
            ))
            ->add('checkGeneral',CheckboxType::class, array(
                'label'    => 'Vérifié?',
                'required' => false,
            ))
            ->add('checkEffectif',CheckboxType::class, array(
                'label'    => 'Vérifié?',
                'required' => false,
            ))
            ->add('checkIndex',CheckboxType::class, array(
                'label'    => 'Vérifié?',
                'required' => false,
            ))
            ->add('checkCursus',CheckboxType::class, array(
                'label'    => 'Vérifié?',
                'required' => false,
            ))
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
            'data_class' => 'AppBundle\Entity\Formation',
            'etablissements' => $etablissements,
            'localisations' => $localisations
        ));
    }
}
