<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un titre pour l\'article'
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le titre de l\article doit contenir au moins {{ limit }} caractéres.',
                        'max' => 75,
                        'maxMessage' => 'Le titre de l\article doit contenir au maximum {{ limit }} caractéres.'
                    ])
                ]
            ])
            ->add('content', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer du contenu pour l\'article'
                    ]),
                    new Length([
                        'min' => 50,
                        'minMessage' => 'L\'article doit contenir au moins {{ limit }} caractéres.',
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choississez une catégorie',
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez un ou des badges',
                'required' => false,
                'multiple' => true,
                'query_builder' => function (TagRepository $repo) {
                    return $repo->createQueryBuilder('u')
                    ->orderBy('u.id', 'DESC');
                }
            ])
            ->add('isPublished', CheckboxType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
