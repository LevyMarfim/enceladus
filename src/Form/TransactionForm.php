<?php

namespace App\Form;

use App\Entity\Assets;
use App\Entity\Transactions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('settlement')
            ->add('transaction')
            ->add('operation')
            ->add('type')
            ->add('entry')
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
                'label' => 'Adicionar asset',
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
