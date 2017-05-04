<?php

namespace EditeurBundle\Form;

use AppBundle\Entity\Valorisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValorisationEmbbedForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
//            ->add('valorisation', EntityType::class, [
//                'class' => Valorisation::class,
//                'choice_label' => 'nom',
//                'query_builder' => function(ValorisationRepository $repo) {
//                    return $repo->createIsValorisationQueryBuilder();
//                }
//            ])
            ->add('nom')
            ->add('description')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Valorisation::class
        ]);
    }

}
