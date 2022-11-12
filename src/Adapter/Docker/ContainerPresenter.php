<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Docker;

use Docker\API\Model\ContainerSummaryItem;
use Docker\API\Model\Mount;
use Docker\API\Model\Port;

class ContainerPresenter
{
    public function present(ContainerSummaryItem $containerSummaryItem): array
    {
        return [
            'id' => $containerSummaryItem->getId(),
            'hosts' => $this->getHosts($containerSummaryItem->getPorts()),
            'status' => $containerSummaryItem->getStatus(),
            'image_name' => $containerSummaryItem->getImage(),
            'name' => $containerSummaryItem->getNames()[0],
            'volumes' => $this->getVolumes($containerSummaryItem->getMounts()),
        ];
    }

    public function getVolumes(?array $volumes): array
    {
        if (empty($volumes)) {
            return [];
        }

        $volumesPath = [];

        foreach ($volumes as $volume) {
            if (is_a($volume, Mount::class)) {
                if ($volume->getSource()) {
                    $volumesPath[] = $volume->getSource();
                }
            }
        }

        return $volumesPath;
    }

    protected function getHosts(?array $ports): array
    {
        if (empty($ports)) {
            return [];
        }

        $hosts = [];

        foreach ($ports as $port) {
            if (is_a($port, Port::class)) {
                if ($port->getIP() != '::') {
                    $hosts[] = [
                        'ip' => $port->getIP(),
                        'port' =>$port->getPublicPort(),
                    ];
                }
            }
        }

        return $hosts;
    }
}