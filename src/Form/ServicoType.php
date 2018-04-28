<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Servico;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('valor')
            ->add('descricao')
            ->add('informacoes_adicionais')
            ->add('prazo_entrega')
            ->add('status')
            ->add('imagem', FileType::class)
            ->add('categorias', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nome',
                'multiple' =>  true,
                'expanded' => true
            ])
            ->add("bt_salvar", SubmitType::class, [
                'label' => "Salvar"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Servico::class,
        ]);
    }
}
