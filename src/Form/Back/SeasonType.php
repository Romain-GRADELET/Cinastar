<?php

namespace App\Form\Back;

use App\Entity\Movie;
use App\Entity\Season;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')

            ->add('nbEpisodes')

            ->add('movie', EntityType::class,[
                "multiple" => false,
                "expanded" => false, // false: dropdown / true: radiobutton
                "class" => Movie::class,
                "choice_label" => "title",
                // ? https://symfony.com/doc/5.4/reference/forms/types/entity.html#query-builder
                "query_builder" => function(EntityRepository $entityRepository){
                    // TODO : requete perso : tri par titre
                    // TODO : requete perso : que le type série
                    return $entityRepository->createQueryBuilder('m')
                        // ! Error: Class App\Entity\Movie has no field or association named type.name    
                        // ->where("m.type.name = 'série'")
                        ->join("m.type", "t")
                        ->where("t.name = 'série'")
                        ->orderBy('m.title', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
