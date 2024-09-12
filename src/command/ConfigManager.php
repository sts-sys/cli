<?php
namespace sts\cli;

class ConfigManager
{
    private $config;

    public function __construct(string $configPath = '/../../../config.json')
    {
        $this->config = $this->loadConfig($configPath);
    }

    private function loadConfig(string $configPath): array
    {
        $fullPath = __DIR__ . $configPath;
        if (file_exists($fullPath)) {
            return json_decode(file_get_contents($fullPath), true) ?? [];
        }
        return [];
    }

    public function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
}
