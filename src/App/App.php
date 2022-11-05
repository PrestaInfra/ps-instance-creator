<?php

namespace Prestainfra\PsInstanceCreator\App;

final class App
{
    protected $dockerClient;

    public function __construct(DockerClientInterface $dockerClient)
    {
        $this->dockerClient = $dockerClient;
    }

    public static function renderView(): string
    {
        return '';
    }
}