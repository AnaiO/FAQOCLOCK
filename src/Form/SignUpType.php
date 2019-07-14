<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $listener = function (FormEvent $event){
            $user = $event->getData();
            $form = $event->getForm();

            if(is_null($user->getId())){ // si notre id d'objet est null == creation de user
                $form->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options'  => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                    'constraints' => [
                        new NotBlank()
                    ]
                ]);
            } else { //sinon je suis en mise a jour car l'id est present
                $form->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options'  => [
                        'label' => 'Password',
                        'attr' => [
                            'placeholder' => 'Laisser vide si inchangé'
                        ]
                    ],
                    'second_options' => ['label' => 'Repeat Password'],
                ]);
            }
        };
        
        $builder
            ->add('firstname', TextType::class, [
                'constraints' => new NotBlank()
            ])
            ->add('lastname', TextType::class, [
                'constraints' => new NotBlank()
            ])
            ->add('email', EmailType::class, [
                'constraints' => new NotBlank
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, $listener)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['novalidate' => 'novalidate']
        ]);
    }
}
