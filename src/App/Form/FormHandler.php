<?php

namespace Prestainfra\PsInstanceCreator\App\Form;

use Exception;
use Prestainfra\PsInstanceCreator\App\Docker\DockerClientInterface;
use Prestainfra\PsInstanceCreator\App\Docker\DockerValuesProvider;

final class FormHandler
{
    public function getFormValue(string $key)
    {
        return $_POST[$key] ?? $_GET[$key];
    }

    public function isFormSubmit(string $submitName): bool
    {
        return isset($_POST[$submitName]) || isset($_GET[$submitName]);
    }

    public function handleForm(DockerClientInterface $dockerClient): array
    {
        $messages = [];

        try {
            $formOptions = $this->buildContainerOption();
            (new FormValidator())->validate($formOptions);

            $dockerValuesProvider = new DockerValuesProvider($formOptions, $dockerClient);

            return $dockerClient->createPrestaShopInstance($dockerValuesProvider);
        } catch (Exception  $e) {
            $messages[] = $e->getMessage();
        }
        return $messages;
    }

    public function buildContainerOption(): array
    {
        return [
            'image_id' => $this->getFormValue('image_id'),
            //'ports' => $this->getFormValue('ports'),
        ];
    }
}