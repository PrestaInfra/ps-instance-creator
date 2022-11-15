<?php

namespace Prestainfra\PsInstanceCreator\App\Factory;

use Exception;
use Prestainfra\PsInstanceCreator\App\App;
use Prestainfra\PsInstanceCreator\App\Configurator\ConfiguratorInterface;
use Prestainfra\PsInstanceCreator\App\Docker\DockerClientInterface;

abstract class AppFactory
{
    /**
     * @throws Exception
     */
    public static function create(
        DockerClientInterface $dockerClient,
        ConfiguratorInterface $configurator,
        string $templateEngineName
    ) : App
    {
        return new App(
            $dockerClient,
            $configurator,
            TemplateEngineFactory::create($templateEngineName)
        );
    }
}