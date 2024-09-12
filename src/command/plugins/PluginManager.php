<?php
namespace sts\cli\plugins;

class PluginManager
{
    private $pluginDirectory;

    public function __construct(string $pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;
    }

    public function createPlugin(string $name, string $type, array $templateFiles): void
    {
        $pluginPath = $this->pluginDirectory . '/' . $name;

        if (file_exists($pluginPath)) {
            throw new \Exception("Pluginul '$name' există deja.");
        }

        mkdir($pluginPath . '/src', 0755, true);
        mkdir($pluginPath . '/tests', 0755, true);

        foreach ($templateFiles as $fileName => $content) {
            file_put_contents("$pluginPath/$fileName", $content);
        }
    }

    public function listPlugins(): array
    {
        return array_diff(scandir($this->pluginDirectory), ['.', '..']);
    }
}
