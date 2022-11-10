<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Docker;

use Prestainfra\PsInstanceCreator\App\DockerClientInterface;
use Docker\Docker;

class DockerClient implements DockerClientInterface
{
    protected $dockerClient;

    public function __construct()
    {
        $this->dockerClient = Docker::create();
    }

    public function getPrestashopImages(): array
    {
        $dockerImages = $this->dockerClient->imageList();

        if (empty($dockerImages)) {
            return $psDockerImages;
        }

        $psDockerImages = [];

        foreach ($dockerImages as $dockerImage) {
            $psDockerImages[$dockerImage->getId()] = $dockerImage->getRepoTags()[0];
        }

        return $psDockerImages;
    }

    public function createPrestaShopInstance(array $options): array
    {
        return [];
    }
}