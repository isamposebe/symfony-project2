<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewsType extends AbstractType
{
    /** Конструктор для новости
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mainText', TextareaType::class, [
                'label' => 'Текст новости',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пустое поле ввода'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Your first text must be at least {{ limit }} characters long',
                        'maxMessage' => 'Your first text cannot be longer than {{ limit }} characters',
                    ])
                ]
            ])
            ->add('saveNews', SubmitType::class, [
                'label' => 'Сохранить'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
