<?php

namespace App\Form;

use App\Entity\Mobile;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MobileType extends AbstractType
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
            ->add('nbPlayer', TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "(De .. à .. joueurs)"
                ]
            ])
            ->add('message', TextareaType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Contenu (optionel)",
                ]
            ])
            ->add('video', TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Lien vidéo"
                ]
            ])
            ->add('image', FileType::class, [
                "label" => false,
                "required" => false,
                'data_class' => null,
                "attr" => [
                    "placeholder" => "Illustration"
                ]
            ])
            ->add('background', FileType::class, [
                "label" => false,
                "required" => false,
                'data_class' => null,
                "attr" => [
                    "placeholder" => "Image de fond"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mobile::class,
        ]);
    }
}
