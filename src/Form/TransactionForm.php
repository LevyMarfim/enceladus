<?php

namespace App\Form;

use App\Entity\Asset;
use App\Entity\Transaction;
use App\Enums\OperationEnum;
use App\Enums\TransactionTypeEnum;
use App\Form\Type\FeeTypeForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('settlementDate', null, [
                'label' => 'Liquidação',
                'attr' => [
                    'class' => 'text-center',
                    'data-controller' => 'datepicker',
                    'data-datepicker-alt-format-value' => 'd/M/Y',
                    'data-datepicker-alt-input-value' => true,
                    'placeholder' => 'dd/mm/aaaa',
                ],
            ])
            ->add('transactionDate', null, [
                'label' => 'Movimentação',
                'attr' => [
                    'class' => 'text-center',
                    'data-controller' => 'datepicker',
                    'data-datepicker-alt-format-value' => 'd/M/Y',
                    'data-datepicker-alt-input-value' => true,
                    'placeholder' => 'dd/mm/aaaa',
                ],
            ])
            ->add('operation', EnumType::class, [
                'class' => OperationEnum::class,
                'choice_label' => function (OperationEnum $operation): string {
                    return $operation->value;
                },
                'attr' => [
                    'class' => 'form-select text-center',
                ],
            ])
            ->add('type', EnumType::class, [
                'class' => TransactionTypeEnum::class,
                'choice_label' => function (TransactionTypeEnum $transactionType): string {
                    return $transactionType->value;
                },
                'attr' => [
                    'class' => 'form-select text-center',
                ],
            ])
            ->add('entry', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Descreva a entrada',
                ],
            ])
            ->add('value', null, [
                'label' => 'Valor',
                'html5' => false,
                'scale' => 2,
                'rounding_mode' => \NumberFormatter::ROUND_HALFUP,
                'attr' => [
                    'class' => 'form-control',
                    'inputmode' => 'decimal',
                    'pattern' => '^-?\d+(\.\d{1,2})?$',
                    'oninput' => "
                        this.value = this.value
                            .replace(/[^0-9.-]/g, '') // Allow digits, decimal point, and minus
                            .replace(/(\..*)\./g, '$1') // Allow only one decimal point
                            .replace(/(\-.*)\-/g, '$1') // Allow only one minus sign
                            .replace(/^(-?\d*\.?\d{0,2}).*$/, '$1') // Limit to 2 decimal places
                            .replace(/^(-?)\./, '$10.') // Convert . to 0. if needed
                            .replace(/^(-?)0+(\d)/, '$1$2'); // Remove leading zeros
                        // Ensure minus is only at start
                        if (this.value.includes('-') && this.value.indexOf('-') !== 0) {
                            this.value = this.value.replace(/-/g, '');
                        }
                    ",
                    'placeholder' => '0.00'
                ]
            ])
            ->add('invoice', IntegerType::class, [
                'label' => 'Nota Fiscal',
                'attr' => [
                    'class' => 'form-control',
                    'inputmode' => 'numeric',
                    'pattern' => '\d*',
                    'oninput' => "this.value=this.value.replace(/[^0-9]/g,'');",
                    'inputmode' => 'numeric',
                    'min' => 0,
                    'placeholder' => '0000',
                ],
                'required' => false
            ])
            ->add('ticker', EntityType::class, [
                'class' => Asset::class,
                'choice_label' => 'ticker',
                'attr' => [
                    'class' => 'form-select'
                ],
                'required' => false,
            ])
            ->add('amount', IntegerType::class, [
                'label' => 'Quantidade',
                'attr' => [
                    'class' => 'form-control',
                    'inputmode' => 'numeric',
                    'pattern' => '\d*',
                    'oninput' => "this.value=this.value.replace(/[^0-9]/g,'');",
                    'inputmode' => 'numeric',
                    'min' => 0,
                    'placeholder' => '0000',
                ],
                'required' => false
            ])
            ->add('unitPrice', null, [
                'label' => 'Preço unitário',
                'scale' => 6,
                'rounding_mode' => \NumberFormatter::ROUND_HALFUP,
                'attr' => [
                    'class' => 'form-control',
                    'inputmode' => 'decimal',
                    'pattern' => '^-?\d+(\.\d{1,2})?$',
                    'oninput' => "
                        this.value = this.value
                            .replace(/[^0-9.-]/g, '') // Allow digits, decimal point, and minus
                            .replace(/(\..*)\./g, '$1') // Allow only one decimal point
                            .replace(/(\-.*)\-/g, '$1') // Allow only one minus sign
                            .replace(/^(-?\d*\.?\d{0,2}).*$/, '$1') // Limit to 2 decimal places
                            .replace(/^(-?)\./, '$10.') // Convert . to 0. if needed
                            .replace(/^(-?)0+(\d)/, '$1$2'); // Remove leading zeros
                        // Ensure minus is only at start
                        if (this.value.includes('-') && this.value.indexOf('-') !== 0) {
                            this.value = this.value.replace(/-/g, '');
                        }
                    ",
                    'placeholder' => '0.000000'
                ]
            ])
            ->add('comment', null, [
                'label' => 'Comentário',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter a comment',
                ],
                'required' => false
            ])
            ->add('fees', CollectionType::class, [
                'entry_type' => FeeTypeForm::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Taxas/Impostos',
                'attr' => [
                    'class' => 'fee-collection',
                    'data-controller' => 'collection'
                ],
                'required' => false
            ])
            ->add('adicionar', SubmitType::class,[
                'label' => 'Adicionar transação',
                'attr' =>[
                    'class' => 'btn btn-success'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
