<?php
namespace sts\cli;

class Logger
{
    private $logFile;

    public function __construct(string $logFile = '/../../../logs/cli.log')
    {
        $this->logFile = __DIR__ . $logFile;
    }

    public function log(string $message): void
    {
        file_put_contents($this->logFile, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
    }
}
