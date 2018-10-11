<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder
//            ->add('email', EmailType::class)
//            ->add('username', TextType::class)
//            ->add('plainPassword', RepeatedType::class, array(
//                'type' => PasswordType::class,
//                'first_options' => array('label' => 'Password'),
//                'second_options' => array('label' => 'Repeat Password'),
//            ));
        $builder
            ->add("email", EmailType::class)
            ->add("username", TextType::class)
            ->add("plainPassword", RepeatedType::class, [
                "type" => PasswordType::class,
                "invalid_message" => "Passwords does not match"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => User::class,
            "validation_groups" => [
                "Default",
                "Registration"
            ]
        ]);
    }
}
