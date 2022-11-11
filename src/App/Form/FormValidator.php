<?php

namespace Prestainfra\PsInstanceCreator\App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

final class FormValidator
{
    public function validate(array $options): void
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $resolver->resolve($options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['image_id']);

        $resolver->setDefaults([
            'stdin' => true,
            'stdout' => true,
            'stderr' => true,
            'tty' => true,
        ]);

        $resolver->setAllowedTypes('image_id', 'string');
        //$resolver->setAllowedTypes('ports', 'array');
    }
}