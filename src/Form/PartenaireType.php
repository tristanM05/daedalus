<?php

namespace App\Form;

use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Nom du partenaire"
                ]
            ])
            ->add('logo', FileType::class, [
                "label" => false,
                "data_class" => null,
                'mapped' => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Logo (optionel)"
                ]
            ])
            ->add('image', FileType::class, [
                "label" => false,
                "data_class" => null,
                'mapped' => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Illusration (optionel)"
                ]
            ])
            ->add('link', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Lien de redirection"
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Description"
                ]
            ])
            ->add('ordre', IntegerType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Ordre"
                ]
            ])
            ->add('video', TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Lien video (optionel)"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}
