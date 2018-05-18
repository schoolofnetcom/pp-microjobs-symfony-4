<?php

namespace App\Form;

use App\Entity\DadosPessoais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class DadosPessoaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('foto_file', VichImageType::class, [
                'label' => 'Foto do perfil',
                'required' => false,
                'allow_delete' => true,
                'download_label' => 'Ampliar',
                'image_uri' => true,
                'imagine_pattern' => 'thumb_profile'
            ])
//            ->add('foto')
            ->add('curriculo', TextareaType::class, [
                'label' => "Descreva sobre você."
            ])
            ->add('cidade')
            ->add('estado', ChoiceType::class, [
                'choices' => [
                    "Selecione" => "",
                    "Acre" =>	"AC",
                    "Alagoas" =>	"AL",
                    "Amapá" =>	"AP",
                    "Amazonas" =>	"AM",
                    "Bahia" =>	"BA",
                    "Ceará" =>	"CE",
                    "Distrito Federal" =>	"DF",
                    "Espírito Santo" =>	"ES",
                    "Goiás" =>	"GO",
                    "Maranhão" =>	"MA",
                    "Mato Grosso" =>	"MT",
                    "Mato Grosso do Sul" =>	"MS",
                    "Minas Gerais" =>	"MG",
                    "Pará" =>	"PA",
                    "Paraíba" =>	"PB",
                    "Paraná" =>	"PR",
                    "Pernambuco" =>	"PE",
                    "Piauí" =>	"PI",
                    "Rio de Janeiro" =>	"RJ",
                    "Rio Grande do Norte" =>	"RN",
                    "Rio Grande do Sul" =>	"RS",
                    "Rondônia" =>	"RO",
                    "Roraima" =>	"RR",
                    "Santa Catarina" =>	"SC",
                    "São Paulo" =>	"SP",
                    "Sergipe" =>	"SE",
                    "Tocantins" =>	"TO",
                ]
            ])
            ->add('data_nascimento', BirthdayType::class, [
                'widget' => 'choice',
                'format' => "dd/MM/yyyy",
                'placeholder' => [
                    'year' => "Ano", 'month' => 'Mês', 'day' => 'Dia'
                ]
            ])
            ->add('cpf', TextType::class, [
                'label' => "CPF"
            ])
            ->add('telefone_ddd', TextType::class, [
                'label' => "DDD"
            ])
            ->add('telefone_numero', TextType::class, [
                'label' => "Telefone"
            ])
            ->add('logradouro')
            ->add('endereco_numero', TextType::class, [
                'label' => "Número"
            ])
            ->add('bairro')
            ->add('cod_moip')
            ->add('data_cadastro')
            ->add('data_alteracao')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DadosPessoais::class,
        ]);
    }
}
