<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('sigle')
            ->add('lien2')
            ->add('lien3')
            ->add('membre')
            ->add('theme')
            ->add('ufr')
            ->add('localisation')
            ->add('formation')
            ->add('discipline')
            ->add('etablissement')
            ->add('equipement')
            ->add('ed')
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
