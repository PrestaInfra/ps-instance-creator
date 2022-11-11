<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Docker;

use Docker\API\Model\ContainersCreatePostBody;
use Prestainfra\PsInstanceCreator\App\Docker\DockerClientInterface;
use Prestainfra\PsInstanceCreator\App\Docker\DockerValuesProvider;
use Docker\Docker;
use Docker\API\Client as DockerApiClient;

class DockerClient implements DockerClientInterface
{
    protected DockerApiClient $dockerClient;

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

    public function createPrestaShopInstance(DockerValuesProvider $dockerValuesProvider): array
    {
        $containerConfig = new ContainersCreatePostBody();

        $containerConfig->setImage($dockerValuesProvider->get('image_id'));
        $containerConfig->setTty($dockerValuesProvider->getBoolean('tty'));
        $containerConfig->setAttachStdin($dockerValuesProvider->getBoolean('stdin'));
        $containerConfig->setAttachStdout($dockerValuesProvider->getBoolean('stdout'));
        $containerConfig->setAttachStderr($dockerValuesProvider->getBoolean('stderr'));

        $containerCreateResult = $this->dockerClient->containerCreate($containerConfig, [
            'name' => $dockerValuesProvider->get('container_name')
        ]);

        if ($containerCreateResult) {
            $this->dockerClient->containerStart($containerCreateResult->getId());
        }

        return [];
    }
}