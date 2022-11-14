<?php

namespace Prestainfra\PsInstanceCreator\App\Docker;

final class DockerValuesProvider
{
    public const DEFAULT_SHOPS_NBR = 1;
    public const PS_INFRA_NETWORK_ID_ENV_VAR_NAME = 'PS_INFRA_NETWORK_ID';
    public const PS_INFRA_MOUNT_SOURCE_PATH_ENV_VAR_NAME = 'PS_INFRA_MOUNT_SOURCE_PATH';
    public const PS_INFRA_MOUNT_TARGET_PATH_ENV_VAR_NAME = 'PS_INFRA_MOUNT_TARGET_PATH';

    public function __construct(
        protected array $parameters,
        protected DockerClientInterface $dockerClient
    ){}

    public function get(string $key, mixed $default = null, bool $forceFromParam = false): mixed
    {
        if(method_exists($this, $key) && !$forceFromParam) {
            return $this->{$key}();
        }

        return \array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
    }

    public function set(string $key, mixed $value): void
    {
        $this->parameters[$key] = $value;
    }

    public function has(string $key): bool
    {
        return \array_key_exists($key, $this->parameters);
    }

    public function remove(string $key): void
    {
        unset($this->parameters[$key]);
    }

    public function getInt(string $key, int $default = 0, bool $forceFromParam = false): int
    {
        return (int) $this->get($key, $default, $forceFromParam);
    }

    public function getBoolean(string $key, bool $default = false, bool $forceFromParam = false): bool
    {
        return (bool) $this->get($key, $default, $forceFromParam);
    }

    public function getArray(string $key, array $default = [], bool $forceFromParam = false): array
    {
        $value = $this->get($key, $default, $forceFromParam);

        if (!is_array($value)) {
            return $default;
        }

        return $value;
    }

    protected function ports(): array
    {
        return [];
    }

    protected function container_name(): ?string
    {
        if(!$this->has('project_name')) {
            return null;
        }

        return (string) str_replace(' ', '_', $this->get('project_name', null, true));
    }

    protected function shops_number(): int
    {
        return $this->getInt('shops_number', 1, true) ?? self::DEFAULT_SHOPS_NBR;
    }

    protected function network_id(): ?string
    {
        return getenv(self::PS_INFRA_NETWORK_ID_ENV_VAR_NAME);
    }

    protected function mount_source(): ?string
    {
        $mountSourcePath = getenv(self::PS_INFRA_MOUNT_SOURCE_PATH_ENV_VAR_NAME);

        if (empty($mountSourcePath)) {
            return null;
        }

        $projectName = $this->get('project_name');

        if (!empty($projectName) && !str_ends_with($mountSourcePath, $projectName)) {
            $mountSourcePath .= '/'.$projectName;
            $mountSourcePath = str_replace('//', '/', $mountSourcePath);
        }

        return $mountSourcePath;
    }

    protected function mount_target(): ?string
    {
        return getenv(self::PS_INFRA_MOUNT_TARGET_PATH_ENV_VAR_NAME);
    }
}