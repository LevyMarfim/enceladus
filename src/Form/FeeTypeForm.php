<?php
// src/Form/Type/FeeType.php
namespace App\Form;

use App\Enums\TransactionTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

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
                'label' => 'Taxa',
                'placeholder' => 'Selecione um tipo',
                'attr' => [
                    'class' => 'form-select',
                    // 'data-action' => 'change->collection#checkDuplicate',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor selecione um tipo de taxa',
                    ]),
                ],
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Valor',
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'class' => 'form-control',
                    'inputmode' => 'decimal',
                    'step' => '0.01',
                    'pattern' => '^\d+(\.\d{1,2})?$',
                    'oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\d*\.\d{0,2}).*$/, '$1');",
                    'data-action' => 'input->collection#validateAmount',
                    'placeholder' => '0.00',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Por favor informe o valor']),
                    new Regex([
                        'pattern' => '/^\d+(\.\d{1,2})?$/',
                        'message' => 'Informe um valor numérico com até 2 casas decimais'
                    ]),
                    new GreaterThan(['value' => 0, 'message' => 'O valor deve ser maior que zero'])
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