<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SearchAuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('field_name', TextType::class, [
                'label' => 'Author',
                'required' => true,
                'attr' => ['class' => 'authorText'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a field name',
                    ]),
                ]
                ])
            ->add('submit', ButtonType::class, [
                'label' => 'Скрыть новости от автора',
                'attr' => ['class' => 'slowAuthor']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
