<?php

namespace Prestainfra\PsInstanceCreator\App;

use Exception;

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
        if ($this->isFormSubmit('submitForm')) {
            $handleFormResult = $this->handleForm();
            return $this->templateEngine->render('form_result', [
                'response' => $handleFormResult
            ]);
        }

        return $this->templateEngine->render('index', $this->getViewVariables());
    }

    protected function getViewVariables(): array
    {
        return [
            'assets_dir' => _APP_ASSETS_DIR_,
            'ps_docker_images' => $this->dockerClient->getPrestashopImages()
        ];
    }

    protected function isFormSubmit(string $submitName): bool
    {
        return isset($_POST[$submitName]) || isset($_GET[$submitName]);
    }

    protected function getFormValue(string $key)
    {
        return $_POST[$key] ?? $_GET[$key];
    }

    protected function handleForm(): array
    {
        $messages = [];

        try {
            $this->dockerClient->createPrestaShopInstance($this->getContainerOption());
        } catch (Exception  $e) {
            $messages[] = $e->getMessage();
        }
        return $messages;
    }

    protected function getContainerOption(): array
    {
        return [
            'image_id' => $this->getFormValue('image_id'),
            'ports' => $this->getFormValue('ports'),
        ];
    }
}