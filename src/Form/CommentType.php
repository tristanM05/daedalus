<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Nom"
                ]
            ])
            ->add('ville', TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Ville"
                ]
            ])
            ->add('mail', TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "E-mail (ne sera pas affiché)"
                ]
            ])
            ->add('message', TextareaType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Votre message"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
