<?php
namespace sts\cli;

class Installer {

   public static function postInstall()
   {
        if(!defined('APP_PATH'))
            throw new Exception("Failed to check application root path.");

        echo "Rularea scriptului postInstall...\n";
       
        $baseDir = APP_PATH;
        echo "Creează directorul 'bin' dacă nu există...\n";
        if (!file_exists($baseDir . 'bin/')) {
            mkdir($baseDir . 'bin/', 0755, true);
        }

        // Calea către fișierul CLI care va fi creat
        $cliFilePath = $baseDir . 'bin/cli.php';
        echo "Calea către fișierul CLI care va fi creat...\n";

        $cliContent = <<<PHP
            #!/usr/bin/env php
            <?php
            require __DIR__ . '/../vendor/autoload.php';
            
            use sts\cli\CommandRegistry;
            use sts\cli\CommandDispatcher;
            use sts\cli\command\HelpCommand;
            use sts\cli\command\MigrationCommand;
            
            // Verifică dacă opțiunea --setup a fost trecută ca argument
            if (in_array('--setup', $argv)) {
                // Apelează funcția de setup
                echo "Instalarea cli este in curs...";
                setupApplication();
                exit(0);
            }
            
            // Înregistrează comenzile disponibile
            $registry = new CommandRegistry();
            $registry->registerCommand('help', new HelpCommand($registry));
            $registry->registerCommand('migrate:run', new MigrationCommand());
            $registry->registerCommand('migrate:check', new MigrationCommand());
            $registry->registerCommand('migrate:rollback', new MigrationCommand());
            
            $dispatcher = new CommandDispatcher($registry);
            
            // Rulează comanda specificată
            $dispatcher->dispatch($argv);
            
            function setupApplication() {
                logMessage("Rularea scriptului de configurare...");
                createDirectories();
                createConfigurationFiles();
                logMessage("Setup complet!");
                exit(0);
            }
            
            function logMessage($message) {
                file_put_contents(APP_PATH . '/storage/logs/setup.log', $message . PHP_EOL, FILE_APPEND);
            }
            
            function createDirectories() {
                // Creează directoarele necesare
                if (!file_exists(APP_PATH . '/logs') && defined(APP_PATH)) {
                    mkdir(APP_PATH . 'storage/logs', 0755, true);
                    echo "Directorul 'logs' a fost creat.\n";
                }
              
                if (!file_exists(APP_PATH . '/database/migrations') && defined(APP_PATH)) {
                    mkdir(APP_PATH . 'database/migrations', 0755, true);
                    echo "Directorul 'migrations' a fost creat.\n";
                }
                
                logMessage( "Directorul 'logs' este deja creat.\n" );
                logMessage( "Directorul 'migrations' este deja creat.\n" );
                logMessage( "Se creaza fisierul de configurare..." );
            }
            
            function createConfigurationFiles() {
                // Creează fișiere de configurare necesare
                if(!defined(APP_PATH)) return;
              
                $configFilePath = APP_PATH . 'bin/config.json';
                if (!file_exists($configFilePath)) {
                    $configContent = json_encode([
                        'defaultType' => 'module',
                        'pluginDirectory' => 'plugins'
                    ], JSON_PRETTY_PRINT);
                    file_put_contents($configFilePath, $configContent);
                    logMessage( "Fișierul de configurare 'config.json' a fost creat.\n" );
                }
            }
        PHP;
       
        // Creează fișierul CLI
        file_put_contents($cliFilePath, $cliContent);

        // Setează permisiunile fișierului ca fiind executabile
        chmod($cliFilePath, 0755);

        echo "Fișierul CLI a fost creat cu succes la $cliFilePath\n";
        echo "CLI Packege a fost instalat si configurat corespunzator !\n";
        exit(0);
   }
}
