<?php

namespace App\Form;

use App\Entity\CorteCaja;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CorteCajaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('efectivo_inicial', MoneyType::class, [
                'label' => 'Monto inicial en caja',
                'currency' => 'MXN',
                'html5' => true,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '0.00'
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El monto inicial es requerido.']),
                    new Assert\PositiveOrZero(['message' => 'El monto no puede ser negativo.']),
                ],
            ])
            ->add('efectivo_final', MoneyType::class, [
                'label' => 'Monto final contado en caja',
                'currency' => 'MXN',
                'html5' => true,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '0.00'
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El monto final es requerido.']),
                    new Assert\PositiveOrZero(['message' => 'El monto no puede ser negativo.']),
                ],
            ])
            ->add('observacion', TextareaType::class, [
                'label' => 'Observaciones (Opcional)',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CorteCaja::class]);
    }
}