<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Config\FileLocator;

class DocumentationConfigLoader
{
    private array $config = [];

    public function __construct(
        #[Autowire('%kernel.project_dir%')] private readonly string $projectDir,
        private readonly string $documentationPath,
        private readonly Filesystem $filesystem,
    )
    {
        $basePath = $this->projectDir . '/' . $this->documentationPath;
        $filesystem = new Filesystem();
        if (!$this->filesystem->exists($basePath)) {
            return;
        }

        $fileLocator = new FileLocator([$basePath]);

        $configFile = $fileLocator->locate('config.yaml', null, true);

        if ($filesystem->exists($configFile)) {
            $this->config = Yaml::parseFile($configFile);
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    public function getAll(): array
    {
        return $this->config;
    }
}
