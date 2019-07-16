<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min'        => 3,
                        'minMessage' => 'Titre trop court (min attendu : {{ limit }})' ,
                        'max'        => 255,
                        'maxMessage' => 'Titre trop long (max attendu : {{ limit }})' ,
                        ])
                ],
                'label' => 'Titre',
            ])
            ->add('content', TextareaType::class, [
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min'        => 30,
                        'minMessage' => 'Contenu trop court (min attendu : {{ limit }})' ,
                        ])
                ],
                'label' => 'Contenu',
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'attr' => ['novalidate' => 'novalidate']
        ]);
    }
}
