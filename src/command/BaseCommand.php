<?php
namespace sts\cli\command;

abstract class BaseCommand implements CommandInterface
{
    protected function log(string $message): void
    {
        // Logare simplă la fișier
        $logFile = __DIR__ . '/../../../logs/cli.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
    }

    protected function displayError(string $message): void
    {
        fwrite(STDERR, "Eroare: $message\n");
    }

    abstract public function run(array $args): void;
}
