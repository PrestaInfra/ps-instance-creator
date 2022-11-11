<?php

namespace Prestainfra\PsInstanceCreator\Adapter\TemplateEngine;

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Extension\DebugExtension;
use Exception;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Prestainfra\PsInstanceCreator\App\AbstractTemplateEngine;

class Twig extends AbstractTemplateEngine
{
    protected Environment $twig;

    public const FILE_EXTENSION = 'html.twig';

    public function __construct(
        protected string $templatesDir,
        protected string $assetsPath,
        protected ?string $cacheDir = null
    ){

        parent::__construct($templatesDir, $assetsPath, $cacheDir);

        $twigOptions = ['debug' => true];

        $loader = new FilesystemLoader($templatesDir);

        if (null != $cacheDir) {
            $twigOptions['cache'] = $cacheDir;
        }

        $this->twig = new Environment($loader, $twigOptions);
        $this->twig->addFunction(new TwigFunction('load_asset', [$this, 'loadAssetResource']));
        $this->twig->addExtension(new DebugExtension());
    }

    public function render(string $template, array $vars = []): string
    {
        $template = $this->resolveTemplateFile($template, static::FILE_EXTENSION);
        return $this->twig->render($template, $vars);
    }

    /**
     * @throws Exception
     */
    public function loadAssetResource(string $resourceName, bool $useBuildPrefix = true): string
    {
        $jsonManifestVersionStrategy = new JsonManifestVersionStrategy(
            $this->assetsPath.'manifest.json',
            null,
            true
        );

        $package = new Package($jsonManifestVersionStrategy);

        return $package->getUrl($this->assetsPath.$resourceName);
    }
}