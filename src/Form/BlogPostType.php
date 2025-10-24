<?php

namespace App\Form;

use App\Entity\BlogPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class BlogPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Título de la publicación',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El título no puede estar vacío.']),
                    new Length(['min' => 5, 'minMessage' => 'El título debe tener al menos {{ limit }} caracteres.']),
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('categoria', ChoiceType::class, [
                'label' => 'Categoría',
                'required' => true,
                'choices' => [
                    'Prevención' => 'Prevencion',
                    'Cuidado de Heridas' => 'Cuidado de Heridas',
                    'Nutrición y Diabetes' => 'Nutricion y Diabetes',
                    'Calzado y Plantillas' => 'Calzado y Plantillas',
                    'Complicaciones' => 'Complicaciones',
                    'Consejos Diarios' => 'Consejos Diarios',
                ],
                'placeholder' => 'Selecciona una categoría...',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenido',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El contenido no puede quedar vacío.']),
                ],
                'attr' => ['rows' => 8, 'class' => 'form-control'],
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Publicar inmediatamente',
                'required' => false,
                'label_attr' => ['class' => 'form-check-label'],
                'attr' => ['class' => 'form-check-input', 'role' => 'switch'],
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Imagen de portada',
                'help' => 'Sube una imagen en formato JPG o PNG. Tamaño máximo: 5MB.',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Por favor sube una imagen válida (JPG o PNG).',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BlogPost::class,
        ]);
    }
}