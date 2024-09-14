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
}

function logMessage($message) {
    file_put_contents(__DIR__ . '/storage/logs/setup.log', $message . PHP_EOL, FILE_APPEND);
}

function createDirectories() {
    // Creează directoarele necesare
    if (!file_exists(__DIR__ . '/storage/logs/')) {
        mkdir(__DIR__ . 'storage/logs', 0755, true);
        echo "Directorul 'logs' a fost creat.\n";
    }
  
    if (!file_exists(__DIR__ . '/database/migrations/')) {
        mkdir(__DIR__ . '/database/migrations/', 0755, true);
        echo "Directorul 'migrations' a fost creat.\n";
    }
    
    logMessage( "Directorul 'logs' este deja creat.\n" );
    logMessage( "Directorul 'migrations' este deja creat.\n" );
    logMessage( "Se creaza fisierul de configurare..." );
}

function createConfigurationFiles() {
    // Creează fișiere de configurare necesare
    if(!defined(APP_PATH)) return;
  
    $configFilePath = __DIR__ . '/bin/config.json';
    if (!file_exists($configFilePath)) {
        $configContent = json_encode([
            'defaultType' => 'module',
            'pluginDirectory' => 'plugins/'
        ], JSON_PRETTY_PRINT);
        file_put_contents($configFilePath, $configContent);
        logMessage( "Fișierul de configurare 'config.json' a fost creat.\n" );
    }
}
