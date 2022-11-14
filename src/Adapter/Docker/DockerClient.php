<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Docker;

use Docker\API\Model\ContainersCreatePostBody;
use Docker\API\Model\ContainerSummaryItem;
use Docker\API\Model\EndpointSettings;
use Docker\API\Model\HostConfig;
use Docker\API\Model\ImageSummary;
use Docker\API\Model\Mount;
use Docker\API\Model\NetworkingConfig;
use Docker\API\Model\PortBinding;
use Prestainfra\PsInstanceCreator\App\Docker\DockerClientInterface;
use Prestainfra\PsInstanceCreator\App\Docker\DockerValuesProvider;
use Docker\Docker;
use Docker\API\Client as DockerApiClient;
use Exception;
use Docker\API\Model\ContainersCreatePostResponse201;

class DockerClient implements DockerClientInterface
{
    protected DockerApiClient $dockerClient;
    protected array $containersList = [];
    protected array $imagesList = [];

    public function __construct()
    {
        $this->dockerClient = Docker::create();
    }

    private function loadContainers(bool $forceLoad = false): void
    {
        if (!$forceLoad && !empty($this->containersList)) {
            return ;
        }

        $dockerContainers = $this->dockerClient->containerList();

        foreach ($dockerContainers as $dockerContainer) {
            $this->containersList[$dockerContainer->getId()] = $dockerContainer;
        }
    }

    private function loadImages(bool $forceLoad = false): void
    {
        if (!$forceLoad && !empty($this->imagesList)) {
            return ;
        }

        $dockerImages = $this->dockerClient->imageList();

        foreach ($dockerImages as $dockerImage) {
            $this->imagesList[$dockerImage->getId()] = $dockerImage;
        }
    }

    public function getContainerSummaryById(string $containerId, bool $forceLoad = false): ?ContainerSummaryItem
    {
        $this->loadContainers($forceLoad);

        return $this->containersList[$containerId] ?? null;
    }

    protected function getImageSummaryById(string $imageId, bool $forceLoad = false): ?ImageSummary
    {
        $this->loadImages($forceLoad);

        return $this->imagesList[$imageId] ?? null;
    }

    public function getPrestashopImages(): array
    {
        $this->loadImages();

        $imagesList = [];

        foreach ($this->imagesList as $image) {
            $imagesList[$image->getId()] = $image->getRepoTags()[0];
        }

        return $imagesList;
    }

    /**
     * @throws Exception
     */
    public function createPrestaShopInstance(DockerValuesProvider $dockerValuesProvider): array
    {
        $imageSummary = $this->getImageSummaryById($dockerValuesProvider->get('image_id'));

        $containerConfig = (new ContainersCreatePostBody())
            ->setImage($imageSummary->getRepoTags()[0])
            ->setTty($dockerValuesProvider->getBoolean('tty'))
            ->setAttachStdin($dockerValuesProvider->getBoolean('stdin'))
            ->setAttachStdout($dockerValuesProvider->getBoolean('stdout'))
            ->setAttachStderr($dockerValuesProvider->getBoolean('stderr'))
            ->setEnv($dockerValuesProvider->getArray('env_vars'))
        ;

        if(!empty($dockerValuesProvider->get('network_id'))){
            $networkingConfig = new NetworkingConfig();
            $endpointSettings = new EndpointSettings();
            $endpointSettings->setNetworkID($dockerValuesProvider->get('network_id'));
            $networkingConfig->setEndpointsConfig([
                $dockerValuesProvider->get('network_id') => $endpointSettings
            ]);
            $containerConfig->setNetworkingConfig($networkingConfig);
        }

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

        if(!empty($dockerValuesProvider->get('mount_source')) &&
            !empty($dockerValuesProvider->get('mount_target')))
        {
            $defaultVolume = (new Mount())
                ->setSource($dockerValuesProvider->get('mount_source'))
                ->setTarget($dockerValuesProvider->get('mount_target'))
                ->setType('bind')
                ->setConsistency('default')
                ->setReadOnly(false)
            ;

            $hostConfig->setMounts([$defaultVolume]);
        }

        $containerConfig->setHostConfig($hostConfig);

        try {
            $containerCreateResult = $this->dockerClient->containerCreate($containerConfig, [
                'name' => $dockerValuesProvider->get('container_name')
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if (!is_a($containerCreateResult, ContainersCreatePostResponse201::class)) {
            throw new Exception('Error during create container');
        }

        $this->dockerClient->containerStart($containerCreateResult->getId());
        $containerSummaryItem = $this->getContainerSummaryById($containerCreateResult->getId(), true);

        if (null == $containerSummaryItem) {
            throw new Exception('Error during create container');
        }

        return (new ContainerPresenter())->present($containerSummaryItem);
    }
}