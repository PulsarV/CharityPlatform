<?php

namespace AppBundle\Form\Security;

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
            ->add('username', TextType::class, array('label' => 'Логин*:'))
            ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => 'Пароль*:'),
                    'second_options' => array('label' => 'Повторить пароль*:'),
                )
            )
            ->add('email', EmailType::class, array(
                'attr' => array('class' => 'form-control'),
                'label' => 'E-mail*:'
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
            ->add('firstname', TextType::class, array(
                'label' => 'Имя*:',
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Фамилия*:',
            ))
            ->add('birthday', BirthdayType::class, array(
                    'widget' => 'single_text',
                    'input' => 'string',
                    'label' => 'Дата рождения*:',
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