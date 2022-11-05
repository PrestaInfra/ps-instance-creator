<?php

namespace Prestainfra\PsInstanceCreator\App;

final class App
{
    protected $dockerClient;
    protected $templateEngine;

    public function __construct(
        DockerClientInterface $dockerClient,
        TemplateEngineInterface $templateEngine
    ){
        $this->dockerClient = $dockerClient;
        $this->templateEngine = $templateEngine;
    }

    public function renderView(): string
    {
        return $this->templateEngine->render('index.html.twig', []);
    }
}