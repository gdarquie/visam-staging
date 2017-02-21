<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Etablissement;
use AppBundle\Repository\EtablissementRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


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
            ->add('ministere')
            ->add('statut')
            ->add('fc', ChoiceType::class, array(
                'choices'  => array(
                    'oui' => "oui",
                    'non' => "non"
                )))
            ->add('fcLien')
            ->add('etudiants')
            ->add('chercheurs')
            ->add('intervenants')
            ->add('lien2')
            ->add('lien3')
            ->add('localisation', EntityType::class, array(
                'class' => 'AppBundle:Localisation',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
            ))
             ->add('valorisation')
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