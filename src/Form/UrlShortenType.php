<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Url;

class UrlShortenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //We don't use 'UrlType' here because we want to check the URL validation on server and not in browser
        //$builder->add('originalUrl', UrlType::class, ['label'=> false, 'attr' => ['placeholder' => 'Type you URL here']]);

        $builder->add('originalUrl', TextType::class, ['required' => false, 'label'=> false, 'attr' => ['placeholder' => 'Type you URL here']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Url::class,
        ]);
    }
}