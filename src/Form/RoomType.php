<?php

namespace App\Form;

use App\Entity\Difficulty;
use App\Entity\Rooms;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Titre de la salle"
                ]
            ])
            ->add('nbPlayer', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "( De * à * joueurs)"
                ]
            ])
            ->add('message', TextareaType::class, [
                "label" => false,
                'required' => false,
                "attr" => [
                    "placeholder" => "Message de la salle",
                    "class" => "textRoom"
                ]
            ])
            ->add('content', TextareaType::class, [
                "label" => false,
                'required' => false,
                "attr" => [
                    "placeholder" => "Présentation",
                    "class" => "textRoom"
                ]
            ])
            ->add('duration', IntegerType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Duré"
                ]
            ])
            ->add('image', FileType::class,[
                "label" => false,
                "required" => false,
                'data_class' => null,
                "attr" => [
                    "placeholder" => "illustration (optionel)",
                    "class" => "fileRoom"
                ]
            ])
            ->add('video', TextType::class,[
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Video, insérez un lien (optionel)",
                    "class" => "fileRoom"
                ]
            ])
            ->add('background', FileType::class,[
                "label" => false,
                "required" => false,
                'data_class' => null,
                "attr" => [
                    "placeholder" => "Image de fond (optionel)",
                    "class" => "fileRoom"
                ]
            ])
            ->add('difficulty', EntityType::class, [
                "label" => false,
                "class" => Difficulty::class,
                "choice_label" => 'getName',
                "attr" => [
                    "placeholder" => "Difficulté"
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
            'data_class' => Rooms::class,
        ]);
    }
}
