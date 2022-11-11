<?php

namespace Prestainfra\PsInstanceCreator\App\Docker;

interface DockerClientInterface
{
    public function getPrestashopImages(): array;
    public function createPrestaShopInstance(DockerValuesProvider $formValuesProvider): array;
}