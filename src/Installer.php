<?php
namespace sts\cli;

class Installer {
   public static function postInstall()
   {
        echo "Rularea scriptului postInstall...\n";
       
        $baseDir = __DIR__ . '../';
        echo "Creează directorul 'bin' dacă nu există...\n";
        if (!file_exists($baseDir . 'bin/')) {
            mkdir($baseDir . 'bin/', 0755, true);
        }

        // Calea către fișierul CLI care va fi creat
        $cliFilePath = $baseDir . 'bin/cli.php';
        echo "[*] Calea către fișierul CLI care va fi creat...\n";

        $cliContent = <<<PHP
            #!/usr/bin/env php
            <?php
            require __DIR__ . '/../vendor/autoload.php';
            
            use sts\cli\CommandRegistry;
            use sts\cli\CommandDispatcher;
            use sts\cli\command\HelpCommand;
            use sts\cli\command\MigrationCommand;
           
            // Înregistrează comenzile disponibile
            \$registry = new CommandRegistry();
            \$registry->registerCommand('help', new HelpCommand(\$registry));
            \$registry->registerCommand('migrate:run', new MigrationCommand());
            \$registry->registerCommand('migrate:check', new MigrationCommand());
            \$registry->registerCommand('migrate:rollback', new MigrationCommand());
            
            \$dispatcher = new CommandDispatcher(\$registry);
            
            // Rulează comanda specificată
            \$dispatcher->dispatch(\$argv);
        PHP;
       
        // Creează fișierul CLI
        echo "Creează fișierul CLI\n";
        file_put_contents($cliFilePath, $cliContent);

        // Setează permisiunile fișierului ca fiind executabile
        chmod($cliFilePath, 0755);

        echo "Fișierul CLI a fost creat cu succes la $cliFilePath\n";
        echo "CLI Packege a fost instalat si configurat corespunzator !\n";
        exit(0);
   }

   public static function postUpdate()
   {
      self::postInstall();
   }
}
