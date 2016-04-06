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
                        'attr' => array('placeholder' => 'Повторить пароль*:')
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
                'attr' => array('placeholder' => 'Банковские реквизиты:'),
                'required' => false,
            ))
            ->add('address', TextType::class, array(
                'label' => false,
                'attr' => array('placeholder' => 'Адрес:'),
                'required' => false,
            ))
            ->add('phone', TextType::class, array(
                'label' => false,
                'attr' => array('placeholder' => 'Телефон:'),
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
                'label' => false,
                'attr' => array('placeholder' => 'Имя*:'),
            ))
            ->add('lastname', TextType::class, array(
                'label' => false,
                'attr' => array('placeholder' => 'Фамилия*:'),
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