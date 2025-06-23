<?php

namespace App\Form;

use App\Entity\Assets;
use App\Entity\Transactions;
use App\Enums\OperationEnum;
use App\Enums\TransactionTypeEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // Data que liquidação
            ->add('settlement', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'text-center',
                    'data-controller' => 'datepicker',
                    'data-datepicker-alt-format-value' => 'd/M/Y',
                    'data-datepicker-alt-input-value' => true,
                    'placeholder' => 'dd/mm/aaaa',
                ],
            ])
        // Data da transação
            ->add('transaction', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'text-center',
                    'data-controller' => 'datepicker',
                    'data-datepicker-alt-format-value' => 'd/M/Y',
                    'data-datepicker-alt-input-value' => true,
                    'placeholder' => 'dd/mm/aaaa',
                ],
            ])
        // Operação de crédito ou débito
            ->add('operation', EnumType::class, [
                'class' => OperationEnum::class,
                'choice_label' => function (OperationEnum $operation): string {
                    return $operation->value;
                },
                'attr' => [
                    'class' => 'form-select text-center',
                ],
            ])
        // Tipo da operação
            ->add('type', EnumType::class, [
                'class' => TransactionTypeEnum::class,
                'choice_label' => function (TransactionTypeEnum $transactionType): string {
                    return $transactionType->value;
                },
                'attr' => [
                    'class' => 'form-select text-center',
                ],
            ])
        // Descrição da operação
            ->add('entry', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Describe the entry',
                ],
            ])
        // Valor da operação
            ->add('value', NumberType::class, [
                'html5' => false,
                'scale' => 2,
                'rounding_mode' => \NumberFormatter::ROUND_HALFUP,
                'attr' => [
                    'class' => 'form-control text-end',
                    'inputmode' => 'decimal',
                    'pattern' => '^-?\d+(\.\d{1,2})?$',
                    // 'step' => '0.01',
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
                ],
            ])
        // Número da NF
            ->add('invoice', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'inputmode' => 'numeric',
                    'pattern' => '\d*',
                    'oninput' => "this.value=this.value.replace(/[^0-9]/g,'');",
                    'inputmode' => 'numeric',
                    'min' => 0,
                    'placeholder' => '000000',
                ],
                'required' => false
            ])
        // Quantidade de compra/venda do ativo
            ->add('amount', IntegerType::class, [
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
        // Add comment
            ->add('comment', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter a comment',
                ],
                'required' => false
            ])
        // Listra os tickers cadastrados
            ->add('ticker', EntityType::class, [
                'class' => Assets::class,
                'choice_label' => 'ticker',
                'required' => false,
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('adicionar', SubmitType::class,[
                'label' => 'Adicionar transação',
                'attr' =>[
                    'class' => 'btn btn-primary'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transactions::class,
        ]);
    }
}
