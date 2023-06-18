<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                "label" => "Pseudo",
                "attr" => [
                    "placeholder" => "Votre pseudo ..."
                ],
            ])
            ->add('email',EmailType::class,[
                "label" => "Email",
                "attr" => [
                    "placeholder" => "Votre email ..."
                ]
            ])
            ->add('content', TextareaType::class,[
                "label" => "Votre critique",
                "attr"=>[
                    "placeholder" => "Votre critique ..."
                ]
            ])
            ->add('rating',ChoiceType::class,[
                "label" => "Votre avis",
                "choices" => [
                    "Excellent" => 5,
                    "Très bon" => 4,
                    "Bon" => 3,
                    "Peut mieux faire" => 2,
                    "Une vraie bouse" => 1
                ]
            ])
            ->add('reactions', ChoiceType::class,[
                "label" => "Vos sentiments pendant le film/série *",
                "choices" => [
                    "Rire" => "laugh",
                    "Pleurer" => "cry",
                    "Réfléchir" => "think",
                    "Dormir" => "sleep",
                    "Rêver" => "dream"
                ],
                "expanded" => true,
                "multiple" => true,
                "help" => "Plusieurs réponses possibles *"
            ])
            ->add('watchedAt', DateType::class,[
                "label" => "Jour de début de visionnage",
                "widget" => "single_text",
                // On précise qu'on veut un datetime_immutable sinon on aura une erreur car le typage du champs ne sera pas respecté
                "input" => "datetime_immutable"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
