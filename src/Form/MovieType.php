<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                "label" => "Titre du film",
                "attr" => [
                    "placeholder" => "titre du film"
                ]
            ])
            ->add('duration', IntegerType::class,[
                "label" => "Durée du film en minute",
                "attr" => [
                    "placeholder" => "Durée en minute"
                ]
            ])
            ->add('releaseDate', DateType::class,[
                "label" => "Date de sortie",
                "input" => "datetime_immutable"
            ])
            ->add('synopsis',TextareaType::class,[
                "label" => "Synopsis",
                "attr" => [
                    "placeholder" => "synopsis"
                ]
            ])
            ->add('summary', TextareaType::class, [
                "label" => "Résumé",
                "attr" => [
                    "placeholder" => "Résumé"
                ]
            ])
            ->add('poster',UrlType::class,[
                "label" => "Url de l'image",
                "attr" => [
                    "placeholder" => "url"
                ]
            ])
            ->add('type',ChoiceType::class,[
                "label" => "Film ou série",
                "choices" => [
                    "Film" => "Film",
                    "Série" => "Série"
                ]
            ])
            ->add('genres',EntityType::class,[
                "label" => "Genres",
                "class" => Genre::class,
                "multiple" => true,
                "expanded" => true,
                "choice_label" => "name"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
