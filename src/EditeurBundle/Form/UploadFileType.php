<?php

namespace EditeurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class UploadFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('attachment', FileType::class, array(
			'attr' =>array(
				'class' =>'filestyle',
				'data-icon' =>'false',
				'data-buttonText'=>'Parcourir',
				'data-buttonName'=>'btn-primary btn-dark',
				)
			))
			->add('action', HiddenType::class, array(
				'label' => '',
				'error_bubbling' =>	true,
			))
			
			->add('etablissement', HiddenType::class, array(
				'label' => '',
				'error_bubbling' =>	true,
			))
            ->add('field', HiddenType::class, array(
				'label' => '',
				'error_bubbling' =>	true,
			))
            ->add('type', ChoiceType::class, array(
                'choices'  => array(
                    'Formations' => 'F',
                    'Laboratoires' => 'L',
                ),
                'attr' => array(
                    'class' => 'type'
                ),
                'choices_as_values' => true,
                'choice_value' => function ($choice) {
                    if (null === $choice) {
                        return 'F';
                    }

                    return $choice;
                },
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'preferred_choices' => array('F')
            ))
            ->add('cancel', ButtonType::class, array(
                'attr' => array(
                    'class' => 'modal-action modal-close btn-flat'
                ),
                'label' => 'Annuler',
            ))

			->add('upload', SubmitType::class, array(
				'attr' => array(
				    'class' => 'btn-flat'
                    ),
				'label' => 'Importer',
			));

    }

    public function getName()
    {
        return 'uploadfile';
    }
}
