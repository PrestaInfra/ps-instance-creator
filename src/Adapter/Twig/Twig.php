<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Twig;

use Prestainfra\PsInstanceCreator\App\TemplateEngineInterface;

class Twig implements TemplateEngineInterface
{
    protected $twig;

    public function __construct(string $templatesDir, ?string $cacheDir = null)
    {
        $twigOptions = [];

        $loader = new \Twig\Loader\FilesystemLoader($templatesDir);

        if (null != $cacheDir) {
            $twigOptions['cache'] = $cacheDir;
        }

        $this->twig = new \Twig\Environment($loader, $twigOptions);
    }

    public function render(string $template, array $vars = []): string
    {
        return $this->twig->render($template, $vars);
    }
}