<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TwoAuthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auth_code', TextType::class, [
                'label' => 'Authentication Code email:',
                'attr' => [
                    'autocomplete' => 'one-time-code',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('trusted', CheckboxType::class, [
                'label' => 'I\'m on a trusted device',
                'required' => false,
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
