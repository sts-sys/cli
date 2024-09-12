<?php
namespace sts\cli;

use sts\cli\command\CommandInterface;

class CommandRegistry
{
    private $commands = [];

    public function registerCommand(string $name, CommandInterface $command): void
    {
        $this->commands[$name] = $command;
    }

    public function getCommand(string $name): ?CommandInterface
    {
        return $this->commands[$name] ?? null;
    }

    public function listCommands(): array
    {
        return array_keys($this->commands);
    }
}
