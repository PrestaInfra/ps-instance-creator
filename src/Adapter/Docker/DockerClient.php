<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Docker;

use Docker\API\Model\ContainersCreatePostBody;
use Docker\API\Model\HostConfig;
use Docker\API\Model\PortBinding;
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
        $containerConfig = (new ContainersCreatePostBody())
            ->setImage($dockerValuesProvider->get('image_id'))
            ->setTty($dockerValuesProvider->getBoolean('tty'))
            ->setAttachStdin($dockerValuesProvider->getBoolean('stdin'))
            ->setAttachStdout($dockerValuesProvider->getBoolean('stdout'))
            ->setAttachStderr($dockerValuesProvider->getBoolean('stderr'))
        ;

        $shopsNbr = $dockerValuesProvider->getInt('shops_number');

        $portMap = new \ArrayObject();
        $portsBinding = [];

        // Expose host port for multi-shop case :
        for ($i = 1; $i <= $shopsNbr; $i++) {
            $portsBinding[] = (new PortBinding())
                ->setHostIp($dockerValuesProvider->get('host'))
            ;
        }

        $portMap[$dockerValuesProvider->get('exposed_port')] = $portsBinding;
        $hostConfig = new HostConfig();
        $hostConfig->setPortBindings($portMap);

        $containerConfig->setHostConfig($hostConfig);

        $containerCreateResult = $this->dockerClient->containerCreate($containerConfig, [
            'name' => $dockerValuesProvider->get('container_name')
        ]);

        if ($containerCreateResult) {
            $this->dockerClient->containerStart($containerCreateResult->getId());
        }

        return [];
    }
}