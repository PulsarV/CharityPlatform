<?php

namespace AppBundle\Form\Cabinet;

use AppBundle\Entity\Charity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tagName', TextType::class, [
                'attr' => array('autofocus' => true),
                'label' => 'Назва тегу*',
                'required' => true,
            ])
            ->add('charities', EntityType::class, [
                'label' => 'Благочинні запити',
                'class' => 'AppBundle\Entity\Charity',
                'choice_label' => 'title',
                'multiple' => true,
                'required' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Tag',
            'required' => false,
        ]);
    }
}
