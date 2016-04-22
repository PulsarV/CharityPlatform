<?php
namespace AppBundle\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', PasswordType::class, array(
            'label' => 'Старий пароль',
        ));
        $builder->add('newPassword', RepeatedType::class, array(
            'type' => 'password',
            'invalid_message' => 'Поля нового паролю повинні співпадати.',
            'required' => true,
            'first_options'  => array('label' => 'Новий пароль'),
            'second_options' => array('label' => 'Повторіть новий пароль'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Form\Security\ChangePasswordModel'
        ]);
    }
}