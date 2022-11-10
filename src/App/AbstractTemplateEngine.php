<?php

namespace Prestainfra\PsInstanceCreator\App;

abstract class AbstractTemplateEngine implements TemplateEngineInterface
{
    public function __construct(
        protected string $templatesDir,
        protected string $assetsPath,
        protected ?string $cacheDir = null
    ){
    }

    protected function resolveTemplateFile(string $templateName, string $extension): string
    {
        return $templateName.'.'.$extension;
    }
}