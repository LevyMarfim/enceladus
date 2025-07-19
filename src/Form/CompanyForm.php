<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Sector;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nome',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('sector', EntityType::class, [
                'label' => 'Setor',
                'class' => Sector::class,
                'choice_label' => 'sector',
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('cnpj', null, [
                'label' => 'CNPJ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '00.000.000/0000-00',
                    // 'maxlength' => '18',
                    // 'data-mask' => 'cnpj',
                    'data-controller' => 'cnpj-mask',
                    'data-cnpj-mask-target' => 'input',
                ],
            ])
            ->add('isin', null, [
                'label' => 'ISIN',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('adicionar', SubmitType::class,[
                'label' => 'Adicionar empresa',
                'attr' =>[
                    'class' => 'btn btn-success'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
