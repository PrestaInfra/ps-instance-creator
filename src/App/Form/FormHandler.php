<?php

namespace Prestainfra\PsInstanceCreator\App\Form;

use Exception;
use Prestainfra\PsInstanceCreator\App\Configurator\ConfiguratorInterface;
use Prestainfra\PsInstanceCreator\App\Docker\DockerClientInterface;
use Prestainfra\PsInstanceCreator\App\Docker\DockerValuesProvider;

final class FormHandler
{
    public const ENV_VARS_DELIMITER = ';';

    public function __construct(
        protected ConfiguratorInterface $configurator
    ){}

    public function handleForm(DockerClientInterface $dockerClient): array
    {
        $messages = [];

        try {
            $formOptions = $this->buildContainerOption();
            $formOptions = (new FormValidator())->validate($formOptions);

            $dockerValuesProvider = new DockerValuesProvider($formOptions, $dockerClient, $this->configurator);

            return $dockerClient->createPrestaShopInstance($dockerValuesProvider);
        } catch (Exception  $e) {
            $messages[] = $e->getMessage();
        }

        return $messages;
    }

    public function getFormValue(string $key)
    {
        return $_POST[$key] ?? $_GET[$key];
    }

    public function has(string $key): bool
    {
        return isset($_POST[$key]) || isset($_GET[$key]);
    }

    public function isFormSubmit(string $submitName): bool
    {
        return isset($_POST[$submitName]) || isset($_GET[$submitName]);
    }

    public function buildContainerOption(): array
    {
        return [
            'image_id' => $this->getFormValue('image_id'),
            'project_name' => $this->getFormValue('project_name'),
            'shops_number' => (int) $this->getFormValue('shops_number'),
            'env_vars' => $this->getEnvVars(),
        ];
    }

    public function isAdvancedContainer(): bool
    {
        return (bool) $this->getFormValue('project_type');
    }

    protected function getEnvVars(): array
    {
        $envVars = [
            'IS_ADVANCED_CONTAINER='.(int) $this->isAdvancedContainer(),
        ];

        $formEnvVars = $this->getFormValue('env_vars');

        if (!$this->isAdvancedContainer() || empty($formEnvVars)) {
            $envVars;
        }

        $formEnvVarsList = explode(self::ENV_VARS_DELIMITER, $formEnvVars);

        if (empty($formEnvVarsList)) {
            $envVars;
        }

        foreach ($formEnvVarsList as $envVarLine) {
            $envVarInfos = explode('=', $envVarLine);

            if (empty($envVarInfos) || count($envVarInfos) != 2) {
                continue;
            }

            $envVars[] = sprintf('%s=%s', trim($envVarInfos[0]), $envVarInfos[1]);
        }

        return $envVars;
    }
}