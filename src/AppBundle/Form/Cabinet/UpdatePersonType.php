<?php

namespace AppBundle\Form\Cabinet;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UpdatePersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'label' => 'Ім\'я користувача*:',
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Прізвище*:',
            ))
            ->add('birthday', BirthdayType::class, array(
                    'widget' => 'single_text',
                    'input' => 'string',
                    'label' => 'Дата народження*:',
                )
            )
            ->add('avatarFileName', FileType::class, array(
                'required' => false,
                'data_class' => null,
                'mapped' => true,
                'label' => 'Аватар:'
            ))
            ->add('bankDetails', TextareaType::class, array(
                'label' => 'Банковські реквізити:',
                'required' => false,
            ))
            ->add('address', TextType::class, array(
                'label' => 'Адреса:',
                'required' => false,
            ))
            ->add('phone', TextType::class, array(
                'label' => 'Телефон:',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Person'
        ));
    }
}