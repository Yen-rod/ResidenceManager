<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class Users1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login')
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [ 
                    'placeholder' => '',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'require' => true
                 ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Apellido(s)',
                'attr' => [ 
                    'placeholder' => '',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'require' => true
                 ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'attr' => [ 
                    'placeholder' => '',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'require' => true
                 ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'attr' => [ 
                    'placeholder' => 'Numerica',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'require' => true
                 ]
            ])
// //agragamos un botón
//             ->add('submit', SubmitType::class, [
//                 'label' => 'Guardar',
//                 'attr' => [ 
//                     'class' => 'btn btn-primary'
//                 ]
//             ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
