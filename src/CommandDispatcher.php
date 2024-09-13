<?php
namespace sts\cli;

class CommandDispatcher
{
    private $commandRegistry;

    public function __construct(CommandRegistry $commandRegistry)
    {
        $this->commandRegistry = $commandRegistry;
    }

    public function dispatch(array $args): void
    {
        if (count($args) < 2) {
            echo "Utilizare: php bin/cli.php [comanda:nume] [parametrii]\n";
            return;
        }

        $commandName = $args[1];
        $command = $this->commandRegistry->getCommand($commandName);

        if ($command === null) {
            echo "Comandă necunoscută: $commandName\n";
            return;
        }

        $command->run(array_slice($args, 2));
    }
}
