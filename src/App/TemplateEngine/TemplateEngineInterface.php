<?php

namespace Prestainfra\PsInstanceCreator\App\TemplateEngine;

interface TemplateEngineInterface {
    public function render(string $template, array $vars = []): string;
}