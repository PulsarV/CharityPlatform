<?php

namespace AppBundle\Form\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('titleCriteria', CheckboxType::class, array(
                'label'    => 'Шукати по заголовкам запитів',
                'required' => false,
                'value' => true,
                'disabled' => true
            ))
            ->add('contentCriteria', CheckboxType::class, array(
                'label'    => 'Шукати по текстам запитів',
                'required' => false,
            ))
            ->add('authorCriteria', CheckboxType::class, array(
                'label'    => 'Шукати по авторам запитів',
                'required' => false,
            ))
            ->add('categoryCriteria', CheckboxType::class, array(
                'label'    => 'Шукати по категоріям запитів',
                'required' => false,
            ))
            ->add('tagsCriteria', CheckboxType::class, array(
                'label'    => 'Шукати по тегам запитів',
                'required' => false,
            ));
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
