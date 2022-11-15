<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Configurator;

use Prestainfra\PsInstanceCreator\App\Configurator\ConfiguratorInterface;
use Symfony\Component\Dotenv\Dotenv;

class Configurator implements ConfiguratorInterface
{
    public function __construct(string $envFilePath)
    {
        (new Dotenv())->load($envFilePath);
    }

    public function get(string $key): mixed
    {
        return getenv($key);
    }
}