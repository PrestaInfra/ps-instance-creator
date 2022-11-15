<?php

require 'config/defines.inc.php';
require 'vendor/autoload.php';

use Prestainfra\PsInstanceCreator\Adapter\Configurator\Configurator;
use Prestainfra\PsInstanceCreator\Adapter\Docker\DockerClient;
use Prestainfra\PsInstanceCreator\App\Factory\AppFactory;

$appConfigurator = new Configurator(_APP_ROOT_DIR_ . '/config/parameters.yaml');
$app = AppFactory::create(new DockerClient($appConfigurator), $appConfigurator, 'Twig');

echo $app->renderView();