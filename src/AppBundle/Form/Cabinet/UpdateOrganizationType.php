<?php

namespace AppBundle\Form\Cabinet;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UpdateOrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organizationName', TextType::class, array('label' => 'Назва організації*:'))
            ->add('organizationDocuments', TextareaType::class, array(
                'label' => 'Деталі организації*:',
            ))
            ->add('activityProfile', TextType::class, array(
                'label' => 'Направлення діяльності організації*:',
            ))
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
            ->add('website', TextType::class, array(
                'label' => 'Веб-сайт:',
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
            'data_class' => 'AppBundle\Entity\Organization'
        ));
    }
}