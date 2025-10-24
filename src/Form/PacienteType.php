<?php

namespace App\Form;

use App\Entity\Paciente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType; // Usamos TelType para semántica
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PacienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre completo',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ej. Juan Pérez Rodríguez',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El nombre no puede estar vacío.']),
                    new Assert\Length(['min' => 3, 'minMessage' => 'El nombre es muy corto.']),
                ],
            ])
            
            ->add('telefono', TelType::class, [
                'label' => 'Teléfono (10 dígitos)',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ej. 5512345678',
                    'maxlength' => 10,
                    'inputmode' => 'numeric', 
                    'pattern' => '[0-9]{10}', 
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'El teléfono no puede estar vacío.']),
                    new Assert\Length([
                        'min' => 10,
                        'max' => 10,
                        'exactMessage' => 'El teléfono debe tener exactamente {{ limit }} dígitos.',
                    ]),
                    new Assert\Regex('/^\d{10}$/', 'Ingresa un número de teléfono válido.'),
                ],
            ])
            ->add('fechaNacimiento', DateType::class, [
                'label' => 'Fecha de nacimiento',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La fecha de nacimiento es obligatoria.']),
                    new Assert\LessThanOrEqual([
                        'value' => 'today',
                        'message' => 'La fecha de nacimiento no puede ser futura.'
                    ]),
                ],
            ])
            ->add('sexo', ChoiceType::class, [
                'label' => 'Sexo',
                'required' => true,
                'choices' => [
                    'Masculino' => 'M',
                    'Femenino' => 'F',
                ],
                'placeholder' => 'Selecciona una opción...',
                'attr' => [
                    'class' => 'form-select',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Debes seleccionar el sexo.']),
                    new Assert\Choice([
                        'choices' => ['M', 'F'],
                        'message' => 'Por favor, selecciona una opción válida.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paciente::class,
        ]);
    }
}