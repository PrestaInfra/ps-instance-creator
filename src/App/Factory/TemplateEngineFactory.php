<?php

namespace Prestainfra\PsInstanceCreator\App\Factory;

use Prestainfra\PsInstanceCreator\App\AbstractTemplateEngine;
use Exception;

abstract class TemplateEngineFactory
{
    public const TEMPLATE_ENGINE_NAMESPACE = 'Prestainfra\PsInstanceCreator\Adapter\TemplateEngine\\';

    /**
     * @throws Exception
     */
    public static function create(string $templateEngineClassName): AbstractTemplateEngine
    {
        $fullClassName = static::TEMPLATE_ENGINE_NAMESPACE.$templateEngineClassName;

        if (!class_exists($fullClassName)) {
            throw new Exception(sprintf('Template engine %s not found: ', $fullClassName));
        }

        try {
            $templateEngineId = strtolower($templateEngineClassName);

            $templateEngine = new $fullClassName(
                _APP_TEMPLATES_DIR_.$templateEngineId,
                _APP_ASSETS_DIR_,
                _APP_CACHE_DIR_.$templateEngineId
            );

            if (!is_a($templateEngine, AbstractTemplateEngine::class)) {
                throw new Exception('Template engine must be an instance of: '. AbstractTemplateEngine::class);
            }

            return $templateEngine;

        } catch (Exception $e) {
            throw new Exception('Error during load Template engine : '.$e->getMessage());
        }
    }
}