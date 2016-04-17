<?php

namespace AppBundle\Form\Cabinet;

use AppBundle\Entity\Category;
use AppBundle\Entity\Charity;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CharityType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => array('autofocus' => true),
                'label' => 'Заголовок',
                'required' => true,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Текст',
                'required' => true,
            ])
            ->add('category', EntityType::class, [
                'label' => 'Категорія',
                'class' => Category::class,
                'choice_label' => 'title',
                'required' => true,
            ])
            ->add('banner', FileType::class, [
                'label' => 'Банер',
                'required' => false,
                'data_class' => null,
                'mapped' => true,
            ])
            ->add('needMoney', IntegerType::class, [
                'label' => 'Потрібно коштів',
                'required' => true,
            ])
            ->add('video', TextType::class, [
                'label' => 'Відео',
            ])
            ->add('tags', EntityType::class, [
                'label' => 'Ключові слова',
                'class' => 'AppBundle\Entity\Tag',
                'choice_label' => 'tagName',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('uploadedFiles', FileType::class, [
                'label' => 'Зображення',
                'multiple' => true,
                'data_class' => null,
                'required' => false,
                'mapped' => true
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var Charity $charity */
            $charity = $event->getData();
            $form = $event->getForm();
            $user = $this->tokenStorage->getToken()->getUser();
            if($user->getRole() == 'ROLE_ADMIN') {
                $form->add('user', EntityType::class, [
                    'label' => 'Автор',
                    'class' => 'AppBundle\Entity\User',
                    'choice_label' => 'username',
                    'required' => true,
                ]);
            } elseif ($user->getRole() == 'ROLE_USER') {
                $charity->setUser($user);
                $user->addCharity($charity);
            }
        });
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
