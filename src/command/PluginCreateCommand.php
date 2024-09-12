<?php
namespace sts\cli\command;

use sts\cli\ConfigManager;
use sts\cli\TemplateRenderer;
use sts\cli\plugin\PluginManager;

class PluginCreateCommand extends BaseCommand
{
    private $configManager;
    private $templateRenderer;
    private $pluginManager;

    public function __construct()
    {
        $this->configManager = new ConfigManager();
        $this->templateRenderer = new TemplateRenderer();
        $this->pluginManager = new PluginManager(__DIR__ . '/../../../plugins');
    }

    public function run(array $args): void
    {
        if (count($args) < 1) {
            $this->displayError("Utilizare: php bin/cli.php plugin:create [nume_plugin] [tip_plugin (opțional)]");
            return;
        }

        $pluginName = $args[0];
        $pluginType = $args[1] ?? $this->configManager->get('defaultType', 'module');
        $templateDirectory = __DIR__ . '/../../../templates/' . $pluginType;

        $templateFiles = [
            'src/' . $pluginName . 'Plugin.php' => $this->templateRenderer->renderTemplate("$templateDirectory/PluginClass.php.tpl", ['pluginName' => $pluginName]),
            'tests/' . $pluginName . 'PluginTest.php' => $this->templateRenderer->renderTemplate("$templateDirectory/PluginTest.php.tpl", ['pluginName' => $pluginName]),
            'README.md' => "# Plugin: $pluginName\n\nDescrierea pluginului.\n"
        ];

        try {
            $this->pluginManager->createPlugin($pluginName, $pluginType, $templateFiles);
            echo "Pluginul '$pluginName' de tip '$pluginType' a fost creat cu succes.\n";
        } catch (\Exception $e) {
            $this->displayError($e->getMessage());
            $this->log("Eroare la crearea pluginului: " . $e->getMessage());
        }
    }
}
