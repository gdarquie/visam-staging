<?php
namespace AppBundle\Form;
use AppBundle\Entity\Axe,
use AppBundle\Entity\Labo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AxeEmbeddedForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('axe', EntityType::class, [
                'class' => Axe::class,
                'choice_label' => 'nom',
                'query_builder' => function(AxeRepository $repo) {
                    return $repo->createIsScientistQueryBuilder();
                }
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Axe::class
        ]);
    }
}