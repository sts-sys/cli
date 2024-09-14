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
    echo "Rularea scriptului de configurare...\n";

    // Exemplu de configurări inițiale
    createDirectories();
    createConfigurationFiles();
    echo "Setup complet!\n";
}

function createDirectories() {
    // Creează directoarele necesare
    if (!file_exists(__DIR__ . '/../logs') && defined(APP_PATH)) {
        mkdir(APP_PATH . 'storage/logs', 0755, true);
        echo "Directorul 'logs' a fost creat.\n";
    }
  
    if (!file_exists(__DIR__ . '/../migrations') && defined(APP_PATH)) {
        mkdir(APP_PATH . 'database/migrations', 0755, true);
        echo "Directorul 'migrations' a fost creat.\n";
    }
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
        echo "Fișierul de configurare 'config.json' a fost creat.\n";
    }
}
