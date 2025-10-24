<?php

namespace App\Form;

use App\Entity\Consulta;
use App\Entity\Paciente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('paciente', EntityType::class, [
                'class' => Paciente::class,
                'choice_label' => 'nombre',
                'label' => 'Paciente',
                'placeholder' => 'Selecciona un paciente...',
                'attr' => ['class' => 'form-select']
            ])
            ->add('fechaConsulta', DateTimeType::class, [
                'label' => 'Fecha y Hora de la Consulta',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('motivo', TextareaType::class, [
                'label' => 'Motivo de la Consulta',
                'attr' => ['class' => 'form-control', 'rows' => 3],
            ])
            ->add('diagnostico', TextareaType::class, [
                'label' => 'Diagnóstico',
                'attr' => ['class' => 'form-control', 'rows' => 4],
            ])
            ->add('tratamiento', TextareaType::class, [
                'label' => 'Tratamiento',
                'attr' => ['class' => 'form-control', 'rows' => 4],
            ])
            ->add('observacion', TextareaType::class, [
                'label' => 'Observaciones (Opcional)',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 2],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consulta::class,
        ]);
    }
}