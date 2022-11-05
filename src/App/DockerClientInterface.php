<?php

namespace Prestainfra\PsInstanceCreator\App;

interface DockerClientInterface
{
    public function getPrestashopImages(): array;
    public function createPrestaShopInstance(array $options): array;
}