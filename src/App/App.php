<?php

namespace Prestainfra\PsInstanceCreator\App;

use Exception;
use Prestainfra\PsInstanceCreator\App\Docker\DockerClientInterface;
use Prestainfra\PsInstanceCreator\App\Form\FormHandler;
use Prestainfra\PsInstanceCreator\App\TemplateEngine\TemplateEngineInterface;
use Prestainfra\PsInstanceCreator\App\Repository\PrestaShopRepository;
use Prestainfra\PsInstanceCreator\App\Repository\AppRepository;
use Prestainfra\PsInstanceCreator\App\Configurator\ConfiguratorInterface;

final class App
{
    protected FormHandler $formHandler;
    protected AppRepository $appRepository;
    protected PrestaShopRepository $prestaShopRepository;

    public function __construct(
        protected DockerClientInterface $dockerClient,
        protected ConfiguratorInterface $configurator,
        protected TemplateEngineInterface $templateEngine
    ){
        $this->formHandler = new FormHandler($this->configurator);
        $this->appRepository = new AppRepository();
        $this->prestaShopRepository = new PrestaShopRepository();
    }

    public function renderView(): string
    {
        if ($this->formHandler->isFormSubmit('submitForm')) {
            try {
                $handleFormResult = $this->formHandler->handleForm($this->dockerClient);
            } catch (Exception $e) {
                return $this->templateEngine->render('errors', [
                    'messages' => [$e->getMessage()]
                ]);
            }

            return $this->templateEngine->render('container-summary', [
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
            'entrypoint_repository_url' => $this->configurator->get('PS_ENTRY_POINT_SCRIPT_REPOSITORY_URL'),
        ];
    }
}