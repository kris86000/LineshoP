<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control mb-2', 'placeholder' => 'Enter your email']
            ])
            ->add('pseudo', TextType::class, [
                'attr' => ['class' => 'form-control mb-2', 'placeholder' => 'Enter your pseudo']
            ])
            ->add('name_user', TextType::class, [
                'attr' => ['class' => 'form-control mb-2', 'placeholder' => 'Enter your user name']
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'form-control mb-2', 'placeholder' => 'Enter your firstname']
            ])
            ->add('address', TextType::class, [
                'attr' => ['class' => 'form-control mb-2', 'placeholder' => 'Enter your address']
            ])
            ->add('postal_code', TextType::class, [
                'attr' => ['class' => 'form-control mb-2', 'placeholder' => 'Enter your postal code']
            ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'form-control mb-2', 'placeholder' => 'Enter your city']
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => 'Agree terms  :'
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['class' => 'form-control mb-3', 'autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
