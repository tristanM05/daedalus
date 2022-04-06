<?php

namespace App\Form;

use App\Entity\Citygame;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityGameType extends AbstractType
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
            ->add('video', TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Lien vidéo"
                ]
            ])
            ->add('nbPlayer', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "(De .. à .. joueurs)"
                ]
            ])
            ->add('content', TextareaType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Contenu",
                    "class" => "textGame"
                ]
            ])
            ->add('content2', TextareaType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Message secondaire",
                    "class" => "textGame"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Citygame::class,
        ]);
    }
}
