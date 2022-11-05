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
        return [];
    }

    public function createPrestaShopInstance(array $options): array
    {
        return [];
    }
}