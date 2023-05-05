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
                "label" => "Votre identifiant"
                ])

            ->add('email', EmailType::class, [
                "label" => "Votre Email",
                "placeholder" => "exemple@mail.com"
                ])

            ->add('content', TextareaType::class, [
                "label" => "Commentaire",
                "minlength" => 100,
                ])

            ->add('rating', ChoiceType::class, [
                "label" => "Avis"
            ])
            ->add('reactions',ChoiceType::class, [
                "label" => "Avis"
            ])
            ->add('watchedAt', DateType::class, [
                "format" => "dd-mm-YYYY"
            ])
            //->add('movie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
