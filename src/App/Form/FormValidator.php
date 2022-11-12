<?php

namespace Prestainfra\PsInstanceCreator\App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

final class FormValidator
{
    public function validate(array $options): array
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        return $resolver->resolve($options);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired([
            'image_id',
            'project_name',
            'ports',
            'shops_number',
            'host',
            'exposed_port',
            'env_vars',
        ]);

        $resolver->setDefaults([
            'stdin' => true,
            'stdout' => true,
            'stderr' => true,
            'tty' => true,
            'ports' => [],
            'shops_number' => 1,
            'host' => '0.0.0.0',
            'exposed_port' => '80/tcp',
            'env_vars' => [],
        ]);

        $resolver->setAllowedTypes('image_id', 'string');
        $resolver->setAllowedTypes('project_name', 'string');
        $resolver->setAllowedTypes('ports', 'array');
        $resolver->setAllowedTypes('shops_number', 'int');
        $resolver->setAllowedTypes('host', 'string');
        $resolver->setAllowedTypes('exposed_port', 'string');
        $resolver->setAllowedTypes('env_vars', 'array');
    }
}