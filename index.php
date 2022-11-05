<?php

require 'config/defines.inc.php';
require 'vendor/autoload.php';

use Prestainfra\PsInstanceCreator\Adapter\Docker\DockerClient;
use Prestainfra\PsInstanceCreator\Adapter\Twig\Twig;
use Prestainfra\PsInstanceCreator\App\App;

$dockerClient = new DockerClient();
$templateEngine = new Twig(_APP_TEMPLATES_DIR_, _APP_CACHE_DIR_.'twig');
$app = new App($dockerClient, $templateEngine);

echo $app->renderView();
