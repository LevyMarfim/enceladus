<?php

namespace App\Form;

use App\Entity\Asset;
use App\Enums\AssetTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AssetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ticker', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'pattern' => '^[A-Z]{4}\d{1,2}$',
                    'title' => '4 uppercase letters followed by 1-2 digits (e.g. ABCD1 or ABCD12)',
                    'maxlength' => '6',
                    'data-controller' => 'ticker-validation',
                    'data-action' => 'input->ticker-validation#validate',
                    'data-ticker-validation-target' => 'input',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a ticker',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Z]{4}\d{1,2}$/',
                        'message' => 'Ticker must be exactly 4 uppercase letters followed by 1 or 2 digits (e.g. ABCD1 or ABCD12)',
                    ]),
                ],
            ])
            ->add('company', TextType::class, [
                'label' => 'Empresa',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('type', EnumType::class, [
                'label' => 'Tipo',
                'class' => AssetTypeEnum::class,
                'choice_label' => function (AssetTypeEnum $assetType): string {
                    return $assetType->value;
                },
                'attr' => [
                    'class' => 'form-select',
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
            'data_class' => Asset::class,
        ]);
    }
}
