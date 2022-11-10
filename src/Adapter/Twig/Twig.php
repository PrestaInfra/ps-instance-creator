<?php

namespace Prestainfra\PsInstanceCreator\Adapter\Twig;

use Prestainfra\PsInstanceCreator\App\TemplateEngineInterface;
use Twig\Environment;
use Twig\TwigFunction;
use Exception;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;

class Twig implements TemplateEngineInterface
{
    protected Environment $twig;
    protected string $assetsPath;

    public function __construct(
        string $templatesDir,
        string $assetsPath,
        ?string $cacheDir = null
    ){
        $this->assetsPath = $assetsPath;

        $twigOptions = [];

        $loader = new FilesystemLoader($templatesDir);

        if (null != $cacheDir) {
            $twigOptions['cache'] = $cacheDir;
        }

        $this->twig = new Environment($loader, $twigOptions);
        $this->twig->addFunction(new TwigFunction('load_asset', [$this, 'loadAssetResource']));
    }

    public function render(string $template, array $vars = []): string
    {
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