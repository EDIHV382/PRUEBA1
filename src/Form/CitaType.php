<?php

namespace App\Form;

use App\Entity\Cita;
use App\Entity\Paciente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CitaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', DateTimeType::class, [
                'label' => 'Fecha y hora',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'min' => (new \DateTime())->format('Y-m-d\TH:i'),
                    'step' => 1800,
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La fecha no puede estar vacía.']),
                    new Assert\GreaterThanOrEqual([
                        'value' => 'now',
                        'message' => 'No puedes agendar una cita en una fecha u hora pasada.',
                    ]),
                ],
            ])
            ->add('asistio', CheckboxType::class, [
                'label' => '¿Asistió a la cita?',
                'required' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'form-check-input', 'role' => 'switch'],
            ])
            ->add('paciente', EntityType::class, [
                'class' => Paciente::class,
                'choice_label' => 'nombre',
                'label' => 'Paciente',
                'required' => true,
                'placeholder' => 'Selecciona un paciente',
                'attr' => [
                    'class' => 'form-select',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Debes seleccionar un paciente.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cita::class,
        ]);
    }
}