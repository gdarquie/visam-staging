<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EdType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $etablissements = $options['etablissements'];

        $builder
            ->add('code')
            ->add('nom')
            ->add('lien')
            ->add('laboExt')
            ->add('etabExt')
            ->add('contact')
            ->add('effectif')
            ->add('membre')
             ->add('localisation')
             ->add('etablissement')
             ->add('discipline')
             ->add('labo')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {


        $etablissements = [];

        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ed',
            'etablissements' => $etablissements
        ));
    }
}
