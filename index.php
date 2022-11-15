<?php

require 'config/defines.inc.php';
require 'vendor/autoload.php';

use Prestainfra\PsInstanceCreator\Adapter\Configurator\Configurator;
use Prestainfra\PsInstanceCreator\Adapter\Docker\DockerClient;
use Prestainfra\PsInstanceCreator\App\App;
use Prestainfra\PsInstanceCreator\App\Factory\TemplateEngineFactory;

$app = (new App(
    new DockerClient(),
    new Configurator(_APP_ROOT_DIR_.'/.env'),
    TemplateEngineFactory::create('Twig')
));

echo $app->renderView();
