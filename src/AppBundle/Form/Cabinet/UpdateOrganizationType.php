<?php

namespace AppBundle\Form\Cabinet;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UpdateOrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organizationName', TextType::class, array('label' => 'Название организации*:'))
            ->add('organizationDocuments', TextareaType::class, array(
                'label' => 'Детали организации*:',
            ))
            ->add('activityProfile', TextType::class, array(
                'label' => 'Направление деятельности организации*:',
            ))
            ->add('avatarFileName', FileType::class, array(
                'required' => false,
                'data_class' => null,
                'mapped' => true,
                'label' => 'Аватар:'
            ))
            //TODO: delete role after adding security
            ->add('role', TextType::class)
            ->add('bankDetails', TextareaType::class, array(
                'label' => 'Банковские реквизиты:',
                'required' => false,
            ))
            ->add('address', TextType::class, array(
                'label' => 'Адрес:',
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
            ->add('categories', 'entity', array(
                'class' => 'AppBundle\Entity\Category',
                'choice_label' => 'title',
                'multiple' => 'true',
                'label' => 'Интересующие категории*:',
            ))
            ->add('showOtherCategories', CheckboxType::class, array(
                //TODO: translations
                'label' => 'Отображать благотворительные запросы из других категорий?',
                'required' => false,
            ))
            ->add('followCategories', 'entity', array(
                'class' => 'AppBundle\Entity\Category',
                'choice_label' => 'title',
                'multiple' => 'true',
                'label' => 'Получать письма новостей категорий:',
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