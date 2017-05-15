<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Discipline;
use AppBundle\Entity\Axe;
use AppBundle\Repository\DisciplineRepository;
use AppBundle\Entity\Etablissement;
use AppBundle\Repository\EtablissementRepository;
use AppBundle\Repository\ThesaurusRepository;


class LaboType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $etablissements = $options['etablissements'];

        $builder
            ->add('nom')
            ->add('etabExt')
            ->add('lien')
            ->add('mailcontact')
            ->add('responsable')
            ->add('description')
            ->add('code')
            ->add('type_thesaurus', EntityType::class, array(
                'placeholder' => 'Sélectionner une réponse',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'nom', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByType("type");
                }
            ))
            ->add('theme', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'nom', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByType("theme");
                }
            ))
            ->add('effectif')
            ->add('effectifHesam')
            ->add('sigle')
//            ->add('lien2')
//            ->add('lien3')
            ->add('axes')
//            ->add('membre')
            // ->add('theme')
            // ->add('ufr')
            // ->add('localisation')
            // ->add('formation')
//            ->add('discipline')
            ->add('cnu', EntityType::class, array(
                'class' => 'AppBundle:Discipline',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function (DisciplineRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilderByType('CNU');
                }
            ))
            ->add('sise', EntityType::class, array(
                'class' => 'AppBundle:Discipline',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function (DisciplineRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilderByType('SISE');
                }
            ))
            ->add('hceres', EntityType::class, array(
                'class' => 'AppBundle:Discipline',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function (DisciplineRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilderByType('HCERES');
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

            // ->add('equipement')
            // ->add('ed')
            ->add('checkGeneral',CheckboxType::class, array(
                'label'    => 'Vérifié?',
                'required' => false,
            ))
            ->add('checkContact',CheckboxType::class, array(
                'label'    => 'Vérifié?',
                'required' => false,
            ))
            ->add('checkEtab',CheckboxType::class, array(
                'label'    => 'Vérifié?',
                'required' => false,
            ))
            ->add('checkDescription',CheckboxType::class, array(
                'label'    => 'Vérifié?',
                'required' => false,
            ))
            ->add('checkEffectifs',CheckboxType::class, array(
                'label'    => 'Vérifié?',
                'required' => false,
            ))
            ->add('axes', CollectionType::class, [
                'entry_type' => AxeEmbeddedForm::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $etablissements = [];

        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Labo',
            'etablissements' => $etablissements
        ));
    }
}
