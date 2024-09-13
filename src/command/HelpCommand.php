<?php
namespace sts\cli\command;

use sts\cli\BaseCommand;
use sts\cli\CommandRegistry;

class HelpCommand extends BaseCommand
{
    private $commandRegistry;

    public function __construct(CommandRegistry $registry)
    {
        $this->commandRegistry = $registry;
    }

    public function run(array $args): void
    {
        echo "Utilizare: php bin/cli.php [comanda:nume] [opțiuni]\n\n";
        echo "Comenzi disponibile:\n";

        // Iterează prin comenzile înregistrate și afișează descrierile acestora
        foreach ($this->commandRegistry->listCommands() as $commandName => $command) {
            echo "  $commandName: " . $command->getDescription() . "\n";
        }

        echo "\nPentru mai multe detalii despre o comandă, utilizați: php bin/cli.php help [comanda:nume]\n";
    }

    public function getDescription(): string
    {
        return "Afișează lista comenzilor disponibile și informații despre utilizarea aplicației.";
    }
}
