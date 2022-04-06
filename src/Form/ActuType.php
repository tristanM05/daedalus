<?php

namespace App\Form;

use App\Entity\Actu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Titre"
                ]
            ])
            ->add('image', FileType::class, [
                "label" => false,
                "data_class" => null,
                'mapped' => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "image"
                ]
            ])
            ->add('content', TextareaType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Votre contenu"
                ]
            ])
            ->add('link', TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Lien de redirection"
                ]
            ])
            ->add('button', TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Nom de boutton"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actu::class,
        ]);
    }
}
