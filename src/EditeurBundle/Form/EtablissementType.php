<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Etablissement;
use AppBundle\Repository\EtablissementRepository;
use AppBundle\Repository\ThesaurusRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EtablissementType extends AbstractType
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
            ->add('code')
            ->add('sigle')
            ->add('lien')
            ->add('ministere_thesaurus', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'nom', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByType("tutelle");
                }
            ))
            ->add('statut_thesaurus', EntityType::class, array(
                'placeholder' => 'Sélectionner une réponse',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'nom', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByType("statut");
                }
            ))
            ->add('fc', ChoiceType::class, array(
                'choices'  => array(
                    'oui' => "oui",
                    'non' => "non"
                )))
            ->add('fcLien')
            ->add('etudiants')
            ->add('chercheurs')
            ->add('intervenants')
            ->add('position_thesaurus', EntityType::class, array(
                'placeholder' => 'Sélectionner une réponse',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'nom', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByType("position");
                }
            ))
            ->add('lien2')
            ->add('lien3')
            ->add('localisation', EntityType::class, array(
                'class' => 'AppBundle:Localisation',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
            ))
            ->add('valorisation')
            ->add('entree', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'], // Creates a dropdown of 15 years to control year
                'html5' => false
            ])
            ->add('sortie', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'], // Creates a dropdown of 15 years to control year
                'html5' => false
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Etablissement'
        ));
    }
}
