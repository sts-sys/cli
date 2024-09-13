<?php
namespace sts\cli;

class Installer {

   public static function postInstall()
   {
        if(!defined('APP_PATH'))
           thow new Exception("Failed to check application root path.");
        $baseDir = APP_PATH ?? '';
        // Creează directorul 'bin' dacă nu există
        if (!file_exists($baseDir)) {
            mkdir($baseDir, 0755, true);
        }

        // Calea către fișierul CLI care va fi creat
        $cliFilePath = $baseDir . 'cli.php';

        $cliContent = <<<PHP
        #!/usr/bin/env php
        <?php

        require __DIR__ . '/../vendor/autoload.php';
        
        use sts\cli\CommandDispatcher;
        use sts\cli\CommandRegistry;

        // Înregistrează comenzile
        $registry = new CommandRegistry();
        
        // Adaugă aici comenzile tale, exemplu:
        $registry->registerCommand('plugin:create', new \sts\cli\command\PluginCreateCommand());
        $registry->registerCommand('help', new \sts\cli\command\HelpCommand());
           
        $dispatcher = new CommandDispatcher($registry);
        $dispatcher->dispatch(\$argv);

        PHP;
        // Creează fișierul CLI
        file_put_contents($cliFilePath, $cliContent);

        // Setează permisiunile fișierului ca fiind executabile
        chmod($cliFilePath, 0755);

        echo "Fișierul CLI a fost creat cu succes la $cliFilePath\n";
   }
}
