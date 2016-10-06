<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('niveau')
            ->add('typediplome')
            ->add('effectif')
            ->add('lien2')
            ->add('lien3')
            ->add('responsable')
        //     ->add('membre')
            ->add('tag')
        //     ->add('theme')
        //     ->add('localisation')
        //     ->add('labo')
             ->add('etablissement')
        //     ->add('metier')
        //     ->add('ufr')
             ->add('discipline')
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
