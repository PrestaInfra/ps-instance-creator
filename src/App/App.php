<?php

namespace Prestainfra\PsInstanceCreator\App;

use Prestainfra\PsInstanceCreator\App\Docker\DockerClientInterface;
use Prestainfra\PsInstanceCreator\App\Form\FormHandler;
use Prestainfra\PsInstanceCreator\App\TemplateEngine\TemplateEngineInterface;

final class App
{
    protected FormHandler $formHandler;

    public function __construct(
        protected DockerClientInterface $dockerClient,
        protected TemplateEngineInterface $templateEngine
    ){
        $this->formHandler = new FormHandler();
    }

    public function renderView(): string
    {
        if ($this->formHandler->isFormSubmit('submitForm')) {
            $handleFormResult = $this->formHandler->handleForm($this->dockerClient);
            return $this->templateEngine->render('form_result', [
                'response' => $handleFormResult
            ]);
        }

        return $this->templateEngine->render('index', $this->getViewVariables());
    }

    protected function getViewVariables(): array
    {
        return [
            'ps_docker_images' => $this->dockerClient->getPrestashopImages()
        ];
    }
}