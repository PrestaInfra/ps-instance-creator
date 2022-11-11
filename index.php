<?php

require 'config/defines.inc.php';
require 'vendor/autoload.php';

use Prestainfra\PsInstanceCreator\Adapter\Docker\DockerClient;
use Prestainfra\PsInstanceCreator\Adapter\TemplateEngine\Twig;
use Prestainfra\PsInstanceCreator\App\App;
use Prestainfra\PsInstanceCreator\App\Factory\TemplateEngineFactory;


$dockerClient = new DockerClient();
$templateEngine = TemplateEngineFactory::create('Twig');
$app = new App($dockerClient, $templateEngine);

echo $app->renderView();
