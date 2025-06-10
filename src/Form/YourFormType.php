<?php

// src/Form/YourFormType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YourFormType extends AbstractType
{
    // In YourFormType.php
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('options', ChoiceType::class, [
                'choices' => [
                    'Orange' => 'option1',
                    'Banana' => 'option2',
                    'Grape' => 'option3',
                    'Melon' => 'option4',
                    'Strawberry' => 'option5',
                    'Mango' => 'option6',
                    'Grape' => 'option7',
                ],
                'multiple' => true,
                'expanded' => false,
                'label' => 'Select Options',
                'autocomplete' => true,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
    }
}