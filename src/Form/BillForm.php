<?php

namespace App\Form;

use App\Entity\Bill;
use App\Entity\BillType;
use App\Entity\Company;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateReference', null, [
                'label' => 'Competência',
                'attr' => [
                    'class' => 'text-center',
                    'data-controller' => 'datepicker',
                    'data-datepicker-alt-format-value' => 'M/Y',
                    'data-datepicker-alt-input-value' => true,
                    'placeholder' => 'mm/aaaa',
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
            ->add('comment', null, [
                'label' => 'Comentário',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('bill', EntityType::class, [
                'label' => 'Conta',
                'class' => BillType::class,
                'choice_label' => 'bill',
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('adicionar', SubmitType::class,[
                'label' => 'Adicionar conta',
                'attr' =>[
                    'class' => 'btn btn-success'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bill::class,
        ]);
    }
}
