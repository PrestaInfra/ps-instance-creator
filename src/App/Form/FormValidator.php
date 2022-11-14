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
            'network_id',
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
            'network_id' => null,
        ]);

        $resolver
            ->setAllowedTypes('image_id', 'string')
            ->setAllowedTypes('project_name', 'string')
            ->setAllowedTypes('ports', 'array')
            ->setAllowedTypes('shops_number', 'int')
            ->setAllowedTypes('host', 'string')
            ->setAllowedTypes('exposed_port', 'string')
            ->setAllowedTypes('env_vars', 'array')
            ->setAllowedTypes('env_vars', 'array')
            ->setAllowedTypes('network_id', ['null', 'string'])
        ;
    }
}