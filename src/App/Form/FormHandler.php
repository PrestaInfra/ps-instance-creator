<?php

namespace Prestainfra\PsInstanceCreator\App\Form;

use Exception;
use Prestainfra\PsInstanceCreator\App\Docker\DockerClientInterface;
use Prestainfra\PsInstanceCreator\App\Docker\DockerValuesProvider;

final class FormHandler
{
    public function handleForm(DockerClientInterface $dockerClient): array
    {
        $messages = [];

        try {
            $formOptions = $this->buildContainerOption();
            $formOptions = (new FormValidator())->validate($formOptions);

            $dockerValuesProvider = new DockerValuesProvider($formOptions, $dockerClient);

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
        ];
    }
}