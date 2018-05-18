<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('email')
            ->add('senha', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'As senhas devem ser idênticas.',
                'first_options' => ['label' => "Senha"],
                'second_options' => ['label' => "Repite a Senha"],
            ])
//            ->add('status')
//            ->add('token')
//            ->add('data_cadastro')
//            ->add('data_alteracao')
//            ->add('roles')
            ->add("enviar", SubmitType::class, [
                'label' => "Enviar"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
