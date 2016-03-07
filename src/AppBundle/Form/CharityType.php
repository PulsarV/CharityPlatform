<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => array('autofocus' => true),
                'label' => 'заголовок',
                'required' => true,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'текст',
                'required' => true,
            ])
            ->add('category', EntityType::class, [
                'label' => 'категорія',
                'class' => Category::class,
                'choice_label' => 'title',
                'required' => true,
            ])
            ->add('banner', FileType::class, [
                'label' => 'банер',
                'required' => true,
            ])
            ->add('needMoney', IntegerType::class, [
                'label' => 'потрібно коштів',
                'required' => true,
            ])
            ->add('images', FileType::class, [
                'label' => 'зображення',
                'required' => true,
            ])
            ->add('video', FileType::class, [
                'label' => 'відео',
                'required' => true,
            ])
            ->add('tags', EntityType::class, [
                'label' => 'ключові слова',
                'class' => 'AppBundle\Entity\Tag',
                'choice_label' => 'tagName',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('user', EntityType::class, [
                'label' => 'Автор',
                'class' => 'AppBundle\Entity\User',
                'choice_label' => 'username',
                'required' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Charity',
            'required' => false,
        ]);
    }
}
