<?php

namespace Prestainfra\PsInstanceCreator\App;

interface TemplateEngineInterface {
    public function render(string $template, array $vars = []): string;
}