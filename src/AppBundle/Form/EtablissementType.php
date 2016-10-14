<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('fc')
            ->add('fcLien')
            ->add('etudiants')
            ->add('chercheurs')
            ->add('lien2')
            ->add('lien3')
            // ->add('localisation')
            // ->add('valorisation')
            // ->add('labo')
            // ->add('formation')
//            ->add('ed')
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
