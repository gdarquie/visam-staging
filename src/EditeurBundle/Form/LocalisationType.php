<?php

namespace EditeurBundle\Form;


use AppBundle\Repository\Metier3Repository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use AppBundle\Repository\DisciplineRepository;
use AppBundle\Repository\EtablissementRepository;
use AppBundle\Repository\LocalisationRepository;
use AppBundle\Repository\ThesaurusRepository;

use AppBundle\Entity\Tag;
use AppBundle\Repository\TagRepository;

class LocalisationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom')
            ->add('type')
            ->add('complet')
            ->add('lat')
            ->add('long')
            ->add('ville')
            ->add('code')
            ->add('cedex')
            ->add('adresse')
            ->add('complementAdresse')
            ->add('region')
            ->add('pays')
            ->add('codePays')

            ->add('localisationId')
            ->add('ufr')
            ->add('labo')
            ->add('formation')
            ->add('etablissement')
            ->add('ed')
        ;
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Localisation'
        ));
    }
}
