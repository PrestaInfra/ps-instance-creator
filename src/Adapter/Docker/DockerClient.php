<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Docker;

use Docker\API\Model\ContainersCreatePostBody;
use Prestainfra\PsInstanceCreator\App\DockerClientInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Docker\Docker;
use Docker\API\Client as DockerApiClient;

class DockerClient implements DockerClientInterface
{
    protected DockerApiClient $dockerClient;
    protected array $options;

    public function __construct()
    {
        $this->dockerClient = Docker::create();
    }

    public function getPrestashopImages(): array
    {
        $dockerImages = $this->dockerClient->imageList();
        $psDockerImages = [];

        if (empty($dockerImages)) {
            return $psDockerImages;
        }

        foreach ($dockerImages as $dockerImage) {
            $psDockerImages[$dockerImage->getId()] = $dockerImage->getRepoTags()[0];
        }

        return $psDockerImages;
    }

    public function createPrestaShopInstance(array $options): array
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);

        $containerConfig = new ContainersCreatePostBody();
        $containerConfig->setImage($resolver->offsetGet('image_id'));

        $containerConfig->setTty($resolver->offsetGet('tty'));
        $containerConfig->setAttachStdin($resolver->offsetGet('stdin'));
        $containerConfig->setAttachStdout($resolver->offsetGet('stdout'));
        $containerConfig->setAttachStderr($resolver->offsetGet('stderr'));

        return [];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['image_id', 'ports']);

        $resolver->setDefaults([
            'stdin' => true,
            'stdout' => true,
            'stderr' => true,
            'tty' => true,
        ]);

        $resolver->setAllowedValues('image_id', 'string');
        $resolver->setAllowedValues('ports', 'array');
    }
}