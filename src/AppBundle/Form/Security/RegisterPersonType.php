<?php

namespace AppBundle\Form\Security;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RegisterPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => false,
                'attr' => array('placeholder' => 'Ім\'я користувача*')
            ))
            ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'label' => false,
                    'first_options'  => array('label' => false,
                        'attr' => array('placeholder' => 'Пароль*:')
                    ),
                    'second_options' => array('label' => false,
                        'attr' => array('placeholder' => 'Повторити пароль*:')
                    ),
                )
            )
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'placeholder' => 'E-mail*:'
                ),
                'label' => false,
            ))
            ->add('avatarFileName', FileType::class, array(
                'required' => false,
                'data_class' => null,
                'mapped' => true,
                'label' => false,
                'attr' => array('placeholder' => 'Аватар:')
            ))
            ->add('bankDetails', TextareaType::class, array(
                'label' => false,
                'attr' => array('placeholder' => 'Банківські реквізити:'),
                'required' => false,
            ))
            ->add('address', TextType::class, array(
                'label' => false,
                'attr' => array('placeholder' => 'Адреса:'),
                'required' => false,
            ))
            ->add('phone', TextType::class, array(
                'label' => false,
                'attr' => array('placeholder' => 'Телефон:'),
                'required' => false,
            ))
            ->add('categories', EntityType::class, array(
                'class' => 'AppBundle\Entity\Category',
                'choice_label' => 'title',
                'multiple' => 'true',
                'label' => 'Категорії, що вас цікавлять*:',
                'required' => false,
            ))
            ->add('showOtherCategories', CheckboxType::class, array(
                'label' => 'Показувати благодійні запити з інших категорій?',
                'required' => false,
            ))
            ->add('followCategories', EntityType::class, array(
                'class' => 'AppBundle\Entity\Category',
                'choice_label' => 'title',
                'multiple' => 'true',
                'label' => 'Отримувати листи від категорій:',
                'required' => false,
            ))
            ->add('firstname', TextType::class, array(
                'label' => false,
                'attr' => array('placeholder' => 'Ім\'я користувача*:'),
            ))
            ->add('lastname', TextType::class, array(
                'label' => false,
                'attr' => array('placeholder' => 'Прізвище*:'),
            ))
            ->add('birthday', BirthdayType::class, array(
                    'widget' => 'single_text',
                    'input' => 'string',
                    'label' => 'Дата народження*:',
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Person',
            'validation_groups' => array(
                'Default',
                'registration',
            ),
        ));
    }
}