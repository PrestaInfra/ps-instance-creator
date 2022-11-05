<?php

require 'config/defines.inc.php';
require 'vendor/autoload.php';

use Prestainfra\PsInstanceCreator\Adapter\Docker\DockerClient;
use Prestainfra\PsInstanceCreator\App\App;

$dockerClient = new DockerClient();
$app = new App($dockerClient);
$app->renderView();
