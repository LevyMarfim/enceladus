<?php
// src/Form/Type/FeeType.php
namespace App\Form\Type;

use App\Enums\TransactionTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeeTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EnumType::class, [
                'class' => TransactionTypeEnum::class,
                'choices' => [
                    TransactionTypeEnum::TAXES,
                    TransactionTypeEnum::SETTLEMENT_TAX,
                    TransactionTypeEnum::OPERATIONAL_TAX,
                    TransactionTypeEnum::CUSTODY_TAX
                ],
                'choice_label' => fn($choice) => $choice->value,
                'attr' => ['class' => 'form-select']
            ])
            ->add('amount', NumberType::class, [
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => '0'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}