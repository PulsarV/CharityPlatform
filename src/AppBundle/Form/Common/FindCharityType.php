<?php

namespace AppBundle\Form\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FindCharityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchQuery', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    //TODO: add translation
                    'placeholder' => 'Search',
                ]
            ])
            ->add('criteria', ChoiceType::class, [

                'label' => false,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'title' => 'Шукати по заголовку запиту',
                    'content' => 'Шукати по тексту запиту',
                    'author' => 'Шукати по автору запиту',
                    'category' => 'Шукати по категорії запиту',
                    'other' => 'Ще якась байда'],
                'choices_as_values' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Form\Common\FindCharityModel'
        ]);
    }
}
