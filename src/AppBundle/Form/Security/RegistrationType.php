<?php

namespace AppBundle\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Ім\'я користувача*'],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => false,
                'first_options'  => [
                    'label' => false,
                    'attr' => ['placeholder' => 'Пароль*'],
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => ['placeholder' => 'Повторіть пароль*'],
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'E-mail*'],
            ])
            ->add('userSelector',  ChoiceType::class, [
                'label' => false,
                'expanded' => false,
                'multiple' => false,
                'mapped' => false,
                'choices' => [
                    'Реєструюсь як фізична особа' => 'person',
                    'Реєструюсь як благодійна організація' => 'organization',
                ],
                'choices_as_values' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Person',
                'validation_groups' => [
                    'registration',
                ],
            ]
        );
    }
}