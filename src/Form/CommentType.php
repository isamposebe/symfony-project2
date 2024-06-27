<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentType extends AbstractType
{
    /** Конструктор формы для комментария
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mainContent', TextType::class, [
                'label' => 'Написать комментарий',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'This value should not be blank.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 255,
                        'minMessage' => 'Your first text must be at least {{ limit }} characters long',
                        'maxMessage' => 'Your first text cannot be longer than {{ limit }} characters'
                    ]),
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить',
                'attr' => ['class' => 'save']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
