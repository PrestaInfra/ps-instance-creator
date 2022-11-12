<?php

namespace Prestainfra\PsInstanceCreator\App;

use Prestainfra\PsInstanceCreator\App\Docker\DockerClientInterface;
use Prestainfra\PsInstanceCreator\App\Form\FormHandler;
use Prestainfra\PsInstanceCreator\App\TemplateEngine\TemplateEngineInterface;
use Prestainfra\PsInstanceCreator\App\Repository\PrestaShopRepository;
use Prestainfra\PsInstanceCreator\App\Repository\AppRepository;

final class App
{
    protected FormHandler $formHandler;
    protected AppRepository $appRepository;
    protected PrestaShopRepository $prestaShopRepository;

    public function __construct(
        protected DockerClientInterface $dockerClient,
        protected TemplateEngineInterface $templateEngine
    ){
        $this->formHandler = new FormHandler();
        $this->appRepository = new AppRepository();
        $this->prestaShopRepository = new PrestaShopRepository();
    }

    public function renderView(): string
    {
        if ($this->formHandler->isFormSubmit('submitForm')) {
            $handleFormResult = $this->formHandler->handleForm($this->dockerClient);

            return $this->templateEngine->render('container_infos', [
                'container' => $handleFormResult
            ]);
        }

        return $this->templateEngine->render('index', $this->getViewVariables());
    }

    protected function getViewVariables(): array
    {
        return [
            'ps_docker_images' => $this->dockerClient->getPrestashopImages(),
            'ps_env_vars' => $this->prestaShopRepository->getDefaultEnvVars(),
        ];
    }
}