<?php
// src/Form/Type/FeeType.php
namespace App\Form;

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
                'attr' => [
                    'class' => 'form-select',
                    'data-action' => 'change->collection#checkDuplicate',
                ],
                'label' => 'Taxa',
            ])
            ->add('amount', NumberType::class, [
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => '0'
                ],
                'label' => 'Valor',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}