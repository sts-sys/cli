#!/usr/bin/env php
<?php
require __DIR__ . '/../vendor/autoload.php'; // Autoloading prin Composer

use sts\cli\command\GreetCommand;

// Lista de comenzi disponibile
$commands = [
    'greet' => new GreetCommand()
];

// Preluarea argumentelor din linia de comandă
$args = $argv;

if (count($args) < 2) {
    echo "Utilizare: php bin/cli.php [comanda]\n";
    exit(1);
}

$commandName = $args[1];

if (!isset($commands[$commandName])) {
    echo "Comandă necunoscută: $commandName\n";
    exit(1);
}

$command = $commands[$commandName];
$command->run(array_slice($args, 2));
