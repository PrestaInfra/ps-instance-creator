<?php

namespace Prestainfra\PsInstanceCreator\App\Configurator;

interface ConfiguratorInterface
{
    public function get(string $key):mixed;
}