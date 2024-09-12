<?php
namespace sts\cli;

class Installer {

   public static function postInstall()
   {
        if(!defined('APP_PATH'))
           thow new Exception("Failed to check application root path.");

        // Creează directorul 'bin' dacă nu există
        if (!file_exists($baseDir)) {
            mkdir($baseDir, 0755, true);
        }

        // Calea către fișierul CLI care va fi creat
        $cliFilePath = $baseDir . '/cli.php';

   }
}