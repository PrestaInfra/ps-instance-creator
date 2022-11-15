<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Configurator;

use Prestainfra\PsInstanceCreator\App\Configurator\ConfiguratorInterface;
use Symfony\Component\Yaml\Yaml;

class Configurator implements ConfiguratorInterface
{
    protected array $configVars;

    public function __construct(string $envFilePath)
    {
        $parameters = Yaml::parseFile($envFilePath);

        if (is_array($parameters)) {
            $this->configVars = $parameters;
        }
    }

    public function get(string $key): mixed
    {
        return $this->configVars[$key] ?? null;
    }
}