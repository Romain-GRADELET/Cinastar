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
            ->add('username', TextType::class, [
                "label" => "votre pseudo:",
                "attr" => [
                    "placeholder" => "votre pseudo ..."
                ]
            ])

            ->add('email', EmailType::class, [
                "label" => "votre email:",
                "attr" => [
                    "placeholder" => "exemple@mail.com"
                ]
            ])

            ->add('content', TextareaType::class, [
                "label" => "votre commentaire:",
                "attr" => [
                    "placeholder" => "Il était bien ce film ...."
                ]
            ])

            // ? https://symfony.com/doc/5.4/reference/forms/types/choice.html
            ->add('rating', ChoiceType::class, [
                // La liste fermée de choix
                "choices" => [
                    "Excellent" => 5,
                    "Très bon" => 4, 
                    "Bon" => 3,
                    "Peut mieux faire" => 2, 
                    "A éviter" => 1
                ],
                // * si on utilise le choiceType (ou ses enfants) toujours ajouter :
                // multiple
                // expanded
                "multiple" => false,
                "expanded" => true,
                "label" => "Comment avez-vous trouvé ce film?"
            ])

            ->add('reactions', ChoiceType::class, [
                // * si on utilise le choiceType (ou ses enfants) toujours ajouter :
                // multiple
                // expanded
                // ! Notice: Array to string conversion
                // si on ne met pas multiple à true, il va y avoir conflit avec le type de donnée de la propriétés
                // tableau ==> multiple=true
                "multiple" => true,
                "expanded" => true,
                'choices'  => [
                    'Rire 😂' => "smile",
                    "Pleurer 😭" => "cry", 
                    "Réfléchir 🤔" => "think",
                    "Dormir 😴" => "sleep", 
                    "Rêver 💭" => "dream"
                ],
            ])

            ->add('watchedAt', DateType::class, [
                //? https://symfony.com/doc/5.4/reference/forms/types/date.html#widget
                "widget" => "single_text",
                // ? https://symfony.com/doc/5.4/reference/forms/types/date.html#input
                "input" => "datetime_immutable"

            ])

            // ! Object of class App\Entity\Movie could not be converted to string
            //->add('movie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
            "attr" => ["novalidate" => 'novalidate']
        ]);
    }
}
