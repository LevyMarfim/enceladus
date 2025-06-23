<?php

namespace App\Form;

use App\Entity\Assets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class AssetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ticker', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'pattern' => '^[A-Za-z]{4}\d{1,2}$',
                    'oninput' => "this.value = this.value.toUpperCase(); this.setCustomValidity(''); if(!/^[A-Z]{0,4}\d{0,2}$/.test(this.value)) this.setCustomValidity('Ticker must be 4 letters followed by 1-2 digits')",
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-z]{4}\d{1,2}$/',
                        'message' => 'Ticker must be 4 letters followed by 1 or 2 digits (e.g., ABCD1 or ABCD12)',
                    ]),
                ],
            ])
            ->add('company', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('type', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('adicionar', SubmitType::class,[
                'label' => 'Adicionar asset',
                'attr' =>[
                    'class' => 'btn btn-primary'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assets::class,
        ]);
    }
}
