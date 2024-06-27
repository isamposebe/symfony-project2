<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\IsNull;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;


class RegistrationFormType extends AbstractType
{
    /** Конструктор формы для регистрации пользователя
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your name'
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 50,
                        'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                        'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters'
                    ])
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Фамилия',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your surname'
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 50,
                        'minMessage' => 'Your surname must be at least {{ limit }} characters long',
                        'maxMessage' => 'Your surname cannot be longer than {{ limit }} characters'
                    ])
                ]
            ])
            ->add('mobilePhone', TextType::class, [
                'label' => 'Номер мобильного телефона ',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your mobile phone'
                    ])
                ]
            ])
            ->add('dateBirth', DateType::class, [
                'label' => 'Дата рождения',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your date of birth NotBlank'
                    ]),
                    new NotNull([
                        'message' => 'Please enter your date of birth IsNotNull'
                    ])
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Имя пользователя',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your username'
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 180,
                        'minMessage' => 'Your username must be at least {{ limit }} characters long',
                        'maxMessage' => 'Your username cannot be longer than {{ limit }} characters'
                    ])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'max' => 180,
                        'minMessage' => 'Your password must be at least {{ limit }} characters long',
                        'maxMessage' => 'Your password must be at least {{ limit }} characters'
                    ])
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => ' You should agree to our terms.',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить',
                'attr' => ['class' => 'app_login']
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
