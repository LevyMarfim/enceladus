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
                    'class' => 'form-select',
                ],
            ])
        // Tipo da operação
            ->add('type', EnumType::class, [
                'class' => TransactionTypeEnum::class,
                'choice_label' => function (TransactionTypeEnum $transactionType): string {
                    return $transactionType->value;
                },
                'attr' => [
                    'class' => 'form-select',
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
            ->add('value')
            ->add('notaFiscal')
            ->add('amount')
            ->add('comment')
            ->add('ticker', EntityType::class, [
                'class' => Assets::class,
                'choice_label' => 'ticker',
                'required' => false,
            ])
            ->add('adicionar', SubmitType::class,[
                'label' => 'Adicionar transação',
                'attr' =>[
                    'class' => 'btn btn-primary'
                ]
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
