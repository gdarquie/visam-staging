<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\EtablissementRepository;
use AppBundle\Entity\User;


use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
//            ->add('password', PasswordType::class)
            ->add('email')
            ->add('etablissement', EntityType::class, array(
                'class' => 'AppBundle:Etablissement',
                'by_reference' => false,
                'multiple' => true,
                'choice_label' => 'nom',
                'query_builder' => function(EtablissementRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }))
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
//                    'Contributeur' => 'ROLE_USER'
                ],
                'multiple' => true,
                'expanded' => true
            ])
            //rôle
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
