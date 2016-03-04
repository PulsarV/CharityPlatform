<?php

namespace AppBundle\Form;

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

class RegisterPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                )
            )
            ->add('email', EmailType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('role', TextType::class)
            ->add('bankDetails', TextareaType::class)
            ->add('address', TextType::class)
            ->add('phone', TextType::class)
            ->add('categories', 'entity', array(
                'class' => 'AppBundle\Entity\Category',
                'choice_label' => 'title',
                'multiple' => 'true',
            ))
            ->add('showOtherCategories', CheckboxType::class, array(
                //TODO: translations
                'label'    => 'Отображать другие категории?',
                'required' => false,
            ))
            ->add('followCategories', 'entity', array(
                'class' => 'AppBundle\Entity\Category',
                'choice_label' => 'title',
                'multiple' => 'true',
            ))
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('birthday', BirthdayType::class, array(
                    //TODO: translations
                    'placeholder' => 'Выберите дату',
                    'widget' => 'single_text',
                    'input' => 'string'
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Person'
        ));
    }
}