<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Etablissement;
use AppBundle\Repository\EtablissementRepository;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etablissement', EntityType::class, array(
            'class' => 'AppBundle:Etablissement',
            'by_reference' => false,
            'multiple' => true,
            'choice_label' => 'nom',
            'query_builder' => function(EtablissementRepository $repo) {
                return $repo->createAlphabeticalQueryBuilder();
            })
        );
    }



    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
//    public function getFirstname()
//    {
//        return $this->getBlockPrefix();
//    }

//    public function getEtablissement()
//    {
//        return 'app_user_registration';
//    }
}

