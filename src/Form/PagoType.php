<?php

namespace App\Form;

use App\Entity\Pago;
use App\Entity\Paciente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly_fecha'] ?? false;

        $builder
            ->add('monto', MoneyType::class, [
                'currency' => 'MXN',
                'label' => 'Monto',
                'required' => true,
                'html5' => true,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0.01,
                    'step' => 0.01,
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El monto no puede estar vacío.']),
                    new Assert\Positive(['message' => 'El monto debe ser un valor positivo.']),
                ],
            ])
            ->add('metodo_pago', ChoiceType::class, [
                'label' => 'Método de pago',
                'required' => true,
                'choices' => [
                    'Efectivo' => 'EFECTIVO',
                    'Tarjeta' => 'TARJETA',
                    'Transferencia' => 'TRANSFERENCIA'
                ],
                'placeholder' => 'Selecciona un método...',
                'attr' => ['class' => 'form-select'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Debes seleccionar un método de pago.']),
                    new Assert\Choice([
                        'choices' => ['EFECTIVO', 'TARJETA', 'TRANSFERENCIA'],
                        'message' => 'Método no válido.'
                    ]),
                ],
            ])
            ->add('tipo_consulta', ChoiceType::class, [
                'label' => 'Tipo de consulta',
                'required' => true,
                'choices' => [
                    'Normal' => 'NORMAL',
                    'Reducida' => 'REDUCIDA'
                ],
                'placeholder' => 'Selecciona un tipo...',
                'attr' => ['class' => 'form-select'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Debes seleccionar un tipo de consulta.']),
                    new Assert\Choice([
                        'choices' => ['NORMAL', 'REDUCIDA'],
                        'message' => 'Tipo no válido.'
                    ]),
                ],
            ])
            ->add('fecha_pago', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha de pago',
                'required' => true,
                'attr' => ['class' => 'form-control', 'readonly' => $readonly],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La fecha de pago es obligatoria.']),
                    new Assert\LessThanOrEqual([
                        'value' => 'today',
                        'message' => 'La fecha de pago no puede ser futura.'
                    ]),
                ],
            ])
            ->add('paciente', EntityType::class, [
                'class' => Paciente::class,
                'choice_label' => 'nombre',
                'label' => 'Paciente',
                'required' => true,
                'placeholder' => 'Selecciona un paciente',
                'attr' => ['class' => 'form-select'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Debes seleccionar un paciente.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pago::class,
            'readonly_fecha' => false,
        ]);
    }
}